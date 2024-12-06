@php use Carbon\Carbon; @endphp
@extends('layouts.user_type.auth')

@section('content')
    @php
        const REQUEST_DETAILS = [
		    ['name' => 'Reference Number', 'attribute' => 'rfno'],
		    ['name' => 'Created', 'attribute' => 'date'],
		    ];

		const USER_DETAILS = [
           ['name' => 'Phone', 'attribute' => 'uphn'],
           ['name' => 'Mobile', 'attribute' => 'umob'],
           ['name' => 'Email', 'attribute' => 'ueml'],
        ];

		const CAR_DETAILS = [
		    ['name' => 'Make', 'attribute' => 'cmak'],
		    ['name' => 'Model', 'attribute' => 'cran'],
		    ['name' => 'Year', 'attribute' => 'cyer'],
		    ['name' => 'Body Style', 'attribute' => 'cbdy'],
		    ['name' => 'Body Trim', 'attribute' => 'cbdt'],
		    ['name' => 'Gearbox', 'attribute' => 'cgbx'],
		    ['name' => 'Fuel', 'attribute' => 'cfue'],
		    ['name' => 'Colour', 'attribute' => 'cclr'],
		    ['name' => 'Engine No.', 'attribute' => 'cenn'],
		    ['name' => 'Engine Capacity', 'attribute' => 'cccs'],
		    ['name' => 'Registration', 'attribute' => 'creg'],
		    ['name' => 'VIN', 'attribute' => 'cvin'],
		    ['name' => 'Description', 'attribute' => 'cdes', 'size' => 'col-12'],
        ];

		const PART_DETAILS = [
//		    ['name' => 'Part ID', 'attribute' => 'part_id'],
		    ['name' => 'Description', 'attribute' => 'part_desc', 'size' => 'col-12'],
		    ['name' => 'Comment', 'attribute' => 'part_comment', 'size' => 'col-12'],
        ];

    @endphp

    <script src="{{ mix('/js/quote-request.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        window.quoteParts = {!! json_encode($quoteRequest->quoteParts, JSON_THROW_ON_ERROR) !!};
    </script>

    @if ($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="card mt-4" style="background-color: #ffebeb; padding: 1rem 1.5rem 0 1.5rem;">
                    <div style="color: #8c0404;">
                        Unable to submit quote: <br />
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif


    <div class="row mb-5">
        <div class="col-12 col-sm-8 col-lg-6 mx-auto">
            <div class="card card-body mt-4">
                <h5 class="mb-0 mb-3">Request Details</h5>

                <div class="row mb-3">
                    <div class="{{ $displayField['size'] ?? 'col-6' }}">
                        <h6 class="mb-0">Reference Number</h6>
                        {{  $quoteRequest->rfno ?? '-' }}
                    </div>

                    <div class="{{ $displayField['size'] ?? 'col-6' }}">
                        <h6 class="mb-0">Date</h6>
                        {{ Carbon::parse($quoteRequest->date)?->format('d/m/Y H:i') }}
                    </div>
                </div>

                <hr />

                <h5 class="mb-3">User Details</h5>
                <div class="row">
                    @foreach(USER_DETAILS as $displayField)
                        <div class="{{ $displayField['size'] ?? 'col-12 col-md-6' }}">
                            <h6 class="mb-0">{{ $displayField['name'] }}</h6>
                            {{  $quoteRequest->{$displayField['attribute']} ?? '-' }}
                        </div>
                    @endforeach
                    <div class="col-12 col-md-6">
                        <h6 class="mb-0">Location</h6>

                        <a rel="nofollow noreferrer" target="_blank"
                           href="https://google.co.uk/maps?q={{ urlencode($quoteRequest->uloc) }}">
                            {{ $quoteRequest->uloc }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-8 col-lg-6 mx-auto">
            <div class="card card-body mt-4">

                <h5 class="mb-3">Vehicle Details</h5>

                <div class="row">
                    @foreach(CAR_DETAILS as $displayField)
                        <div class="mb-4 {{ $displayField['size'] ?? 'col-12 col-md-6' }}">
                            <h6 class="mb-1"> {{ $displayField['name'] }}</h6>
                            {{  $quoteRequest->{$displayField['attribute']} ?? '-' }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 text-center">
            <h3>Requested Parts</h3>
        </div>
    </div>

    <form method="POST" action="{{ route('quote-requests.store') }}">
        @csrf

        <input type="hidden" name="rfno" value="{{ $quoteRequest->rfno }}" />
        
        <div class="row mb-5">
            <div class="col-12 col-md-6">
                @foreach ($quoteRequest->quoteParts as $quotePart)

                    <input type="hidden" name="quote[parts][{{ $loop->index }}][id]"
                           value="{{ $quotePart->id }}" />

                    <input type="hidden" name="quote[parts][{{ $loop->index }}][part_id]"
                           value="{{ $quotePart->part_id }}" />

                    <div class="col-12 mx-auto">
                        <div class="card card-body mt-4">

                            <h5>
                                Part #{{ $quotePart->part_id }}
                                @if($loop->count > 1)
                                    ({{ $loop->iteration }} of {{ $loop->count }})
                                @endif
                            </h5>

                            <div class="row">
                                @foreach (PART_DETAILS as $partDetail)
                                    <div class="mb-4 {{ $partDetail['size'] ?? 'col-12 col-md-6' }}">
                                        <h6 class="mb-1"> {{ $partDetail['name'] }}</h6>
                                        {{  $quotePart->{$partDetail['attribute']} ?: '-' }}
                                    </div>
                                @endforeach
                            </div>

                            <h5 class="mb-3">Quote</h5>

                            <div class="row mb-2">
                                <div class="col-12 col-md-6">
                                    <label for="condition{{ $loop->index }}">
                                        Condition
                                    </label>
                                    <select class="form-control choice-js-search-disabled changes-summary"
                                            name="quote[parts][{{ $loop->index }}][condition]"
                                            id="condition{{ $loop->index }}">
                                        <option
                                            value="1" {{ old('quote.parts.'.$loop->index.'.condition') == '1' ? 'selected' : '' }}>
                                            Used
                                        </option>
                                        <option
                                            value="2" {{ old('quote.parts.'.$loop->index.'.condition') == '2' ? 'selected' : '' }}>
                                            New
                                        </option>
                                        <option
                                            value="3" {{ old('quote.parts.'.$loop->index.'.condition') == '3' ? 'selected' : '' }}>
                                            Reconditioned
                                        </option>
                                        <option
                                            value="4" {{ old('quote.parts.'.$loop->index.'.condition') == '4' ? 'selected' : '' }}>
                                            Remanufactured
                                        </option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="guarantee{{ $loop->index }}" class="form-control-label">Guarantee
                                            (months)</label>
                                        <input class="form-control changes-summary" type="number" min="1"
                                               max="48"
                                               name="quote[parts][{{ $loop->index }}][guarantee]"
                                               id="guarantee{{ $loop->index }}"
                                               value="{{ old('quote.parts.'.$loop->index.'.guarantee') ?: 6 }}"
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12 col-md-6">

                                    <div class="form-group">
                                        <label for="price{{ $loop->index }}">Price</label>
                                        <div class="input-group mb-1">
                                            <span class="input-group-text" id="pound{{ $loop->index }}">&#163;</span>
                                            <input type="number" class="form-control changes-summary" placeholder="0.00"
                                                   aria-label="Price"
                                                   min="0"
                                                   value="{{ old('quote.parts.'.$loop->index.'.price') ?: 0 }}"
                                                   max="100000"
                                                   aria-describedby="pound{{ $loop->index }}"
                                                   name="quote[parts][{{ $loop->index }}][price]"
                                                   id="price{{ $loop->index }}"
                                                   autocomplete="off">
                                        </div>
                                        <div class="">
                                            <small id="price-helper"
                                                   class="form-text text-muted">
                                                <span class="text-xxs">SET TO: &nbsp; </span>
                                                <span class="badge badge-secondary" role="button"
                                                      onclick="$('#price{{ $loop->index }}').val('50.00').change();">50</span>
                                                <span class="badge badge-secondary" role="button"
                                                      onclick="$('#price{{ $loop->index }}').val('75.00').change();">75</span>
                                                <span class="badge badge-secondary" role="button"
                                                      onclick="$('#price{{ $loop->index }}').val('100.00').change();">100</span>
                                                <span class="badge badge-secondary" role="button"
                                                      onclick="$('#price{{ $loop->index }}').val('150.00').change();">150</span>
                                                <span class="badge badge-secondary" role="button"
                                                      onclick="$('#price{{ $loop->index }}').val('200.00').change();">200</span>
                                                <span class="badge badge-secondary" role="button"
                                                      onclick="$('#price{{ $loop->index }}').val('500.00').change();">500</span>
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="price-vat" class="form-control-label">VAT (20%)</label>
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="pound"
                                              style="background-color: rgb(233, 236, 239)">&#163;</span>
                                            <input class="form-control" disabled type="text"
                                                   id="price-vat{{ $loop->index }}"
                                                   value='0.00'
                                                   name="quote[parts]{{ $loop->index }}][vat]"
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-12 col-md-6 mx-auto">
                <div class="card card-body mt-4">

                    <h5 class="mb-3">
                        Delivery @if (count($quoteRequest->quoteParts) > 1)
                            (All Parts)
                        @endif
                    </h5>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">

                            <div class="form-group">
                                <label for="exampleInputAmount">Delivery Cost</label>
                                <div class="input-group mb-1">
                                    <span class="input-group-text" id="delivery-pound">&#163;</span>
                                    <input type="number" class="form-control changes-summary" placeholder="0.00"
                                           aria-label="Delivery"
                                           aria-describedby="pound" name="delivery"
                                           id="delivery"
                                           min="0"
                                           max="1000"
                                           value="{{ old('delivery') ?: 10 }}"
                                           autocomplete="off"
                                    >
                                </div>
                                <div class="">
                                    <small id="delivery-helper"
                                           class="form-text text-muted">
                                        <span class="text-xxs">SET TO: &nbsp; </span>
                                        <span class="badge badge-secondary" role="button"
                                              onclick="$('#delivery').val('5.00').change();">5</span>
                                        <span class="badge badge-secondary" role="button"
                                              onclick="$('#delivery').val('10.00').change();">10</span>
                                        <span class="badge badge-secondary" role="button"
                                              onclick="$('#delivery').val('20.00').change();">20</span>
                                        <span class="badge badge-secondary" role="button"
                                              onclick="$('#delivery').val('30.00').change();">30</span>
                                        <span class="badge badge-secondary" role="button"
                                              onclick="$('#delivery').val('40.00').change();">40</span>
                                        <span class="badge badge-secondary" role="button"
                                              onclick="$('#delivery').val('50.00').change();">50</span>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="vat" class="form-control-label">VAT (20%)</label>
                                <div class="input-group mb-3">
                                        <span class="input-group-text" id="pound"
                                              style="background-color: rgb(233, 236, 239)">&#163;</span>
                                    <input class="form-control" disabled type="text"
                                           value='2.00'
                                           id="delivery-vat"
                                           name="delivery_vat">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-body mt-4">

                    <h5 class="mb-3">
                        Comments
                    </h5>

                    <!-- <dov class="row mb-2">
                         <div class="col-9">
                             <label for="preset">
                                 Preset Message
                             </label>
                             <select class="form-control choice-js" name="preset" id="preset">
                                 <option value="1">More details required (email)</option>
                                 <option value="2">Part number required</option>
                                 <option value="3">Reconditioned</option>
                                 <option value="4">Remanufactured</option>
                             </select>
                         </div>
                     </dov>
                     -->

                    <div class="form-group">
                        <label for="comment-to-buyer">Comment To Buyer</label>
                        <textarea class="form-control" id="comment-to-buyer" name="comment_to_buyer"
                                  rows="3">{{ old('comment_to_buyer') ?: '' }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="comment-to-buyer">
                            <i style="font-size: 1rem;"
                               class="fas fa-lg fa-lock ps-2 pe-2 text-center text-dark text-dark "
                               aria-hidden="true"></i> Private comment</label>
                        <textarea class="form-control" id="comment-to-buyer" name="private_comment"
                                  rows="3">{{ old('private_comment') ?: '' }}</textarea>
                    </div>
                </div>

            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 text-center">
                <h3>Summary</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card card-body mt-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table text-right">
                                    <thead class="bg-default">
                                    <tr>
                                        <th scope="col" class="pe-2 text-start ps-2">Item</th>
                                        <th scope="col" class="pe-2">Condition</th>
                                        <th scope="col" class="pe-2">Guarantee</th>
                                        <th scope="col" class="pe-2">Price</th>
                                        <th scope="col" class="pe-2">VAT</th>
                                        <th scope="col" class="pe-2">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody id="quote-summary-body">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" id="confirm-quote-button"
                                    class=" btn bg-gradient-dark mb-0 ms-lg-auto me-lg-0 me-auto mt-lg-0 mt-2"
                                    disabled>
                                CONFIRM QUOTE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

@endsection
