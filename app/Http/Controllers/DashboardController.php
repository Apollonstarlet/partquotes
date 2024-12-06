<?php

namespace App\Http\Controllers;

use App\Models\PartQuote;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use JsonException;

class DashboardController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $user = request()?->user();

        $todayCountUser = DB::table('part_quote')
            ->where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->count();

        $todayCountAll = DB::table('part_quote')
            ->whereDate('created_at', today())
            ->count();

        $monthCountUser = DB::table('part_quote')
            ->where('user_id', $user->id)
            ->whereBetween('created_at', [now()->subMonth(), now()])
            ->count();

        $monthCountAll = DB::table('part_quote')
            ->whereBetween('created_at', [now()->subMonth(), now()])
            ->count();

        $yearCountUser = DB::table('part_quote')
            ->where('user_id', $user->id)
            ->whereBetween('created_at', [now()->subYear(), now()])
            ->count();

        $yearCountAll = DB::table('part_quote')
            ->whereBetween('created_at', [now()->subYear(), now()])
            ->count();

        $totalCountUser = DB::table('part_quote')
            ->where('user_id', $user->id)
            ->count();

        $totalCountAll = DB::table('part_quote')->count();

        $user = request()?->user();
        $startDate = Carbon::now()->subDays(31);
        $endDate = Carbon::now();
        $dateRange = collect(
            Carbon::parse($startDate)
                ->daysUntil($endDate)
                ->toArray(),
        )->map(function ($date) {
            return $date->format('d M');
        });

        $quotesForUser = PartQuote::where('user_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($item) {
                return $item->created_at->format('d M');
            })
            ->map(function ($items) {
                return $items->count();
            });

        $quotesAllUsers = PartQuote::whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($item) {
                return $item->created_at->format('d M');
            })
            ->map(function ($items) {
                return $items->count();
            });

        $userQuotesByDay = $dateRange
            ->map(function ($date) use ($quotesForUser) {
                return $quotesForUser->has($date) ? $quotesForUser->get($date) : 0;
            })
            ->toArray();

        $allQuotesByDay = $dateRange
            ->map(function ($date) use ($quotesAllUsers) {
                return $quotesAllUsers->has($date) ? $quotesAllUsers->get($date) : 0;
            })
            ->toArray();

        return view('pages.dashboard')->with(compact('todayCountUser',
                'todayCountAll',
                'monthCountUser',
                'monthCountAll',
                'yearCountUser',
                'yearCountAll',
                'totalCountUser',
                'totalCountAll',
                'userQuotesByDay',
                'allQuotesByDay',
                'dateRange')
        );
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
     * @return View
     */
    public function show(int $rfno) {
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
