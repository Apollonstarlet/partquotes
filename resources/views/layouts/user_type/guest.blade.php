@extends('layouts.app')

@section('guest')
    @if(Request::is('login/forgot-password'))
        @include('layouts.navbars.guest.nav')
        @yield('content')
    @else
        <div class="container position-sticky z-index-sticky top-0">

            @if(session()->has('success'))
                <div class="row my-2">
                    <div class="col-12">
                        <div class="bg-success text-white rounded-lg right-3 py-2 px-4">
                            <p class="m-0">{{ session('success')}}</p>
                        </div>
                    </div>
                </div>

            @endif

            @if(session()->has('error'))
                <div class="row my-2">
                    <div class="col-12">
                        <div class="bg-error text-white rounded-lg right-3 py-2 px-4">
                            <p class="m-0">{{ session('success')}}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    @include('layouts.navbars.guest.nav')
                </div>
            </div>
        </div>
        @yield('content')
        @include('layouts.footers.guest.footer')
    @endif
@endsection
