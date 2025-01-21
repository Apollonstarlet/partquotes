@php use Carbon\Carbon; @endphp
@extends('layouts.user_type.auth')

@section('content')

    @if(session('quote-success'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="notification notification-success">
                    {{ session('quote-success') }}
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
                        <a href="last" class="btn bg-gradient-dark mb-2 w-100">Last Request</a>
                        </div>

                        <div class="">
                            <small id="delivery-helper"
                                   class="form-text text-muted">
                                <span class="text-xxs mr-2">VIEW: &nbsp;</span>

                                <a href="?limit=500">
                                    <span class="badge {{ $limit === '500' ? 'badge-dark' : 'badge-secondary' }}"
                                          role="button">500</span>
                                </a>
                                <a href="?limit=1000">
                                    <span class="badge {{ $limit === '1000' ? 'badge-dark' : 'badge-secondary' }}"
                                          role="button">1k</span>
                                </a>
                                <a href="?limit=2000">
                                    <span class="badge {{ $limit === '2000' ? 'badge-dark' : 'badge-secondary' }}"
                                          role="button">2k</span>
                                </a>
                                <a href="?limit=5000">
                                    <span class="badge {{ $limit === '5000' ? 'badge-dark' : 'badge-secondary' }}"
                                          role="button">5k</span>
                                </a>
                                <a href="?limit=10000">
                                    <span class="badge {{ $limit === '10000' ? 'badge-dark' : 'badge-secondary' }}"
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
                        <th data-filter="true"
                            class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Part
                        </th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Make</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Model</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Fuel</th>
                        {{--                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Colour</th>--}}
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Request Date
                        </th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Quote</th>
                        <th class="d-none"></th>
                        <th class="d-none"></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($quoteRequests as $quoteRequest)
                        <tr>
                            <td class="text-sm font-weight-normal">{{ $quoteRequest->quoteRequest->rfno }}</td>
                            <td class="text-sm font-weight-normal">{{ $quoteRequest->part_id }}</td>
                            <td class="text-sm font-weight-normal">{{ Str::limit($quoteRequest->part_desc, $limit = 40, $end = '...') }}</td>
                            <td class="text-sm font-weight-normal">{{ $quoteRequest->quoteRequest?->cmak }}</td>
                            <td class="text-sm font-weight-normal">{{ $quoteRequest->quoteRequest?->cran }}</td>
                            <td class="text-sm font-weight-normal">{{ $quoteRequest->quoteRequest?->cfue }}</td>
                            {{--                            <td class="text-sm font-weight-normal">{{ $quoteRequest->quoteRequest?->cclr }}</td>--}}
                            <td class="text-sm font-weight-normal">{{ Carbon::parse($quoteRequest->quote_request?->date)?->format('d M H:i') }}</td>
                            <td class="text-sm font-weight-normal text-center">
                                <a class="mt-0 mb-0"
                                   href="{{ route('quote-requests.show', $quoteRequest->quoteRequest->rfno ) }}"
                                   data-bs-toggle="tooltip"
                                   data-bs-original-title="Quote"
                                >
                                    <i class="cursor-pointer fas fa-hand-holding-dollar text-dark"></i>

                                </a>
                            </td>
                            <td class="d-none">{{ $quoteRequest->quoteRequest->cvin }}</td>
                            <td class="d-none">{{ $quoteRequest->quoteRequest->creg }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

@endsection
