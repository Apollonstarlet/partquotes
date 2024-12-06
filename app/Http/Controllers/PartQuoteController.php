<?php

namespace App\Http\Controllers;

use App\Models\PartQuote;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use JsonException;

class PartQuoteController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $limit = request('limit');

        if ($limit && is_numeric($limit) && (int)$limit > 0) {
            Cookie::queue(Cookie::make('part-quote-limit', $limit, 525960));
        } else {
            $limit = request()->cookie('part-quote-limit') ?? 1000;
        }

        if (auth()->user()->isAdmin()) {
            $partQuotes = PartQuote::with(['quoteRequest', 'quoteRequestPart', 'user'])
                ->orderBy('created_at', 'desc')
                ->take($limit)
                ->get();
        } else {
            $partQuotes = PartQuote::with(['quoteRequest', 'quoteRequestPart', 'user'])
                ->where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->take($limit)
                ->get();
        }

        return view('pages.part-quotes.index')->with([
            'partQuotes' => $partQuotes,
            'limit' => $limit,
        ]);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $rfno
     */
    public function show(int $rfno) {
        $quoteRequest = QuoteRequest::with('quoteParts')->find($rfno);

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
