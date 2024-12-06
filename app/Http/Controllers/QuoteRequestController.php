<?php

namespace App\Http\Controllers;

use App\Models\PartQuote;
use App\Models\QuoteRequest;
use App\Models\QuoteRequestPart;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use JsonException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class QuoteRequestController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $limit = request('limit');

        if ($limit && is_numeric($limit) && (int)$limit > 0) {
            Cookie::queue(Cookie::make('quote-request-limit', $limit, 525960));
        } else {
            $limit = request()?->cookie('quote-request-limit') ?? 1000;
        }

        $quoteRequests = QuoteRequestPart::with('quoteRequest')
            ->whereHas('quoteRequest', function ($query) {
                $query->whereNull('completed');
            })
            ->take($limit)
            ->get();

        return view('pages.quote-requests.index')->with(['quoteRequests' => $quoteRequests, 'limit' => $limit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     * @throws JsonException
     */
    public function store(Request $request) {
        $request->validate([
            'rfno' => 'required|numeric',
            'quote' => 'required|array',
            'quote.parts' => 'required|array',
            'quote.parts.*.id' => 'required|integer',
            'quote.parts.*.condition' => 'required|integer',
            'quote.parts.*.guarantee' => 'required|integer',
            'quote.parts.*.price' => 'required|numeric',
            'quote.parts.*.part_id' => 'required|numeric',
            'delivery' => 'required|numeric',
            'comment_to_buyer' => 'nullable|string|max:255',
            'private_comment' => 'nullable|string|max:255',
        ]);

        $quoteRequest = QuoteRequest::findOrFail($request->input('rfno'));

        $delivery = round($request->input('delivery') * 1.2 * 100); // 20% VAT, price in pence

        $xml = sprintf(
            '<quot rfno="%s" delp="%s" pcmt="%s" ccmt="%s">',
            $request->input('rfno'),
            $delivery,
            $request->input('private_comment') ?? '',
            $request->input('comment_to_buyer') ?? '',
        );

        $quoteParts = [];
        foreach ($request->input('quote.parts') as $partQuote) {
            if (empty($partQuote['price'])) {
                continue;
            }

            $price = round($partQuote['price'] * 1.2 * 100); // 20% VAT, price in pence
            $id = $partQuote['part_id'];
            $guarantee = $partQuote['guarantee'];
            $condition = $partQuote['condition'];
            $xml .= sprintf(
                '<part pid="%s" gtm="%s" cnd="%s" prce="%s" />',
                htmlspecialchars($id, ENT_QUOTES),
                htmlspecialchars($guarantee, ENT_QUOTES),
                htmlspecialchars($condition, ENT_QUOTES),
                htmlspecialchars($price, ENT_QUOTES),
            );

            $quotePart = new PartQuote();
            $quotePart->quote_request_part_id = $partQuote['id'];
            $quotePart->rfno = $request->input('rfno');
            $quotePart->price = $price;
            $quotePart->delivery = $delivery;
            $quotePart->guarantee = $guarantee;
            $quotePart->condition = $condition;
            $quotePart->user_id = $request->user()->id;

            $quoteParts[] = $quotePart;
        }

        $xml .= '</quot>';

        if (!$quoteParts) {
            $errors = new MessageBag(['request' => ['You must quote at least one part.']]);

            return back()->with('errors', $errors)->withInput();
        }

        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        $endpoint = 'http://webserv.1stchoice.co.uk/1stchoiceServices/SupplierPub.asmx/MakeQuote2';
        $parameters = http_build_query([
            'username' => 'c232',
            'password' => env('FIRST_CHOICE_PASSWORD'),
            'request' => $xml,
        ]);

        $response = Http::withHeaders($headers)
            ->get($endpoint . '?' . $parameters);

        $html = html_entity_decode($response->body());
        $responseXml = @simplexml_load_string($html, "SimpleXMLElement", LIBXML_NOCDATA);
        $response = json_decode(json_encode($responseXml, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);

        $message = $response['resp']['@attributes']['msg'];

        if ($message !== 'OK') {
            $errors = new MessageBag(['request' => ['Request to quoting service failed: ' . $message]]);

            return back()->with('errors', $errors)->withInput();
        }

        $quoteRequest->completed = new DateTime();
        $quoteRequest->save();

        foreach ($quoteParts as $quotePart) {
            $quotePart->save();
        }

        return redirect()
            ->route('quote-requests.index')
            ->with('quote-success', 'Quote #' . $request->input('rfno') . ' successfully submitted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $rfno
     * @return \Illuminate\Contracts\View\View
     */
    public function show(int $rfno) {
        $quoteRequest = QuoteRequest::with('quoteParts')->find($rfno);

        if (!$quoteRequest) {
            throw new HttpException(Response::HTTP_NOT_FOUND);
        }

        return View::make('pages.quote-requests.show')->with('quoteRequest', $quoteRequest);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }
}
