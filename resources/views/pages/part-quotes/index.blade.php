@php use Carbon\Carbon; @endphp
@extends('layouts.user_type.auth')

@section('content')

    @if(session('quote-success'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="card mt-4" style="background-color: #f1fdf6; padding: 1.5rem;">
                    <div style="color: #3abf6f;">
                        {{ session('quote-success') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-3">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Completed Quotes</h5>
                        </div>
                        <div class="">
                            <small id="delivery-helper"
                                   class="form-text text-muted">
                                <span class="text-xxs mr-2">VIEW:  &nbsp;</span>

                                <a href="?limit=500">
                                    <span class="badge {{ $limit === '500' ? 'badge-primary' : 'badge-secondary' }}"
                                          role="button">500</span>
                                </a>
                                <a href="?limit=1000">
                                    <span class="badge {{ $limit === '1000' ? 'badge-primary' : 'badge-secondary' }}"
                                          role="button">1k</span>
                                </a>
                                <a href="?limit=2000">
                                    <span class="badge {{ $limit === '2000' ? 'badge-primary' : 'badge-secondary' }}"
                                          role="button">2k</span>
                                </a>
                                <a href="?limit=5000">
                                    <span class="badge {{ $limit === '5000' ? 'badge-primary' : 'badge-secondary' }}"
                                          role="button">5k</span>
                                </a>
                                <a href="?limit=10000">
                                    <span class="badge {{ $limit === '10000' ? 'badge-primary' : 'badge-secondary' }}"
                                          role="button">10k</span>
                                </a>
                            </small>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">
                    $(() => {
                        let table = new simpleDatatables.DataTable("#datatable", {
                            filterable: true,
                            perPageSelect: [10, 25, 50, 100, 150, 200],
                            columns: [
                                { select: 0, sort: "desc" },
                                { select: 8, sortable: false, searchable: false }
                            ]
                        });
                    });
                </script>
                <table class="table table-flush table-responsive" id="datatable">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Ref no.</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">ID</th>
                        @if(Auth::user() && Auth::user()->isAdmin())
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">User</th>
                        @endif
                        <th data-filter="true"
                            class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Part
                        </th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Make</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Model</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Price</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Guarantee</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Requested At</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Quoted At</th>
                        <th class="d-none"></th>
                        <th class="d-none"></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($partQuotes as $partQuote)
                        <tr>
                            <td class="text-sm font-weight-normal">{{ $partQuote->quoteRequest->rfno }}</td>
                            <td class="text-sm font-weight-normal">{{ $partQuote->quoteRequestPart->part_id }}</td>
                            @if(Auth::user() && Auth::user()->isAdmin())
                                <td class="text-sm font-weight-normal">{{ $partQuote->user?->name || 'Deleted user' }}</td>
                            @endif
                            <td class="text-sm font-weight-normal">{{ Str::limit($partQuote->quoteRequestPart->part_desc, $limit = 40, $end = '...') }}</td>
                            <td class="text-sm font-weight-normal">{{ $partQuote->quoteRequest?->cmak }}</td>
                            <td class="text-sm font-weight-normal">{{ $partQuote->quoteRequest?->cran }}</td>
                            <td class="text-sm font-weight-normal">
                                &pound; {{ number_format($partQuote->price / 100, 2) }}</td>
                            <td class="text-sm font-weight-normal">
                                {{ $partQuote->guarantee }} {{ Str::plural('month', (int) $partQuote->guarantee) }}

                            </td>
                            <td class="text-sm font-weight-normal">{{ Carbon::parse($partQuote->quote_request?->date)?->format('d M Y H:i') }}</td>
                            <td class="text-sm font-weight-normal">{{ Carbon::parse($partQuote->created_at)?->format('d M Y H:i') }}</td>
                            <td class="d-none">{{ $partQuote->quoteRequest->cvin }}</td>
                            <td class="d-none">{{ $partQuote->quoteRequest->creg }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

@endsection
