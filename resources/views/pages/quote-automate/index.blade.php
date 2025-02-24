@php use Carbon\Carbon; @endphp
@extends('layouts.user_type.auth')

@section('content')

    @if(session('autoquote-success'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="card mt-4" style="background-color: #f1fdf6; padding: 1.5rem;">
                    <div style="color: #3abf6f;">
                        {{ session('autoquote-success') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <form id="upload_csv" action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-4" style="text-align: center;">
                            <a href="{{ asset('autoquote-export')}}" class="btn bg-gradient-dark mb-1"><i class="fa fa-cloud-download"></i>&nbsp;&nbsp;Download CSV</a>
                        </div>
			<div class="col-12 col-md-4 mt-1" style="text-align: center;">
                        <input type="file" name="file" id="file" class="form-control">
			</div>
			<div class="col-12 col-md-4" style="text-align: center;">
                        <a id="upload" class="btn bg-gradient-dark mb-1"><i class="fa fa-cloud-upload"></i>&nbsp;&nbsp;Upload Excel</a>
			</div>
                    </div>
                    </form>
                </div>
		<script type="text/javascript">
                $(document).ready(function () {
			var flag = "1";
			$('input#file').on('change', () => {
			  flag = "0";
			  console.log('clicked upload');
			});
			$("a#upload").on("click", function () {
      				if(flag == "0"){
				    $("form#upload_csv").submit();
				}
				console.log('clicked button');
    			});                    
		});
                </script>

                <div class="card-header p-3">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5>Quotes for Automate</h5>
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
                                { select: 9, sortable: false, searchable: false },
                                { select: 10, sortable: false, searchable: false }

                            ]
                        });
                    });
                </script>
                <table class="table table-flush table-responsive" id="datatable">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Make</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Model</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Year From</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Year To</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Description</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Price</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Delivery</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Guarantee</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Condition</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Comment</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Private</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($autoQuotes as $autoQuote)
                        <tr>
                            <td class="text-sm font-weight-normal">{{ $autoQuote->make }}</td>
                            <td class="text-sm font-weight-normal">{{ $autoQuote->model }}</td>
                            <td class="text-sm font-weight-normal">{{ $autoQuote->year_from }}</td>
			    <td class="text-sm font-weight-normal">{{ $autoQuote->year_to }}</td>
			    <td class="text-sm font-weight-normal">{{ $autoQuote->part }}</td>
                            <td class="text-sm font-weight-normal">&pound; {{ number_format($autoQuote->price / 100, 2) }}</td>
                            <td class="text-sm font-weight-normal">&pound; {{ number_format($autoQuote->delivery / 100, 2) }}</td>
                            <td class="text-sm font-weight-normal">
                                {{ $autoQuote->guarantee }} {{ Str::plural('month', (int) $autoQuote->guarantee) }}
                            </td>
                            <td class="text-sm font-weight-normal">@if($autoQuote->condition == "1")Used @elseif($autoQuote->condition == "2")New @elseif($autoQuote->condition == "3")Reconditioned @else Remanufactured @endif</td>
                            <td class="text-sm font-weight-normal">{{ $autoQuote->comment }}</td>
                            <td class="text-sm font-weight-normal">{{ $autoQuote->private }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection
