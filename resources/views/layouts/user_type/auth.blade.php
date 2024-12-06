@extends('layouts.app')

@section('auth')

    @include('layouts.navbars.auth.sidebar')
    <main
        class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">
        @include('layouts.navbars.auth.nav')
        <div class="container-fluid py-4">

            @if(session()->has('success'))
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="notification notification-success">
                            <p class="m-0 text-bold">{{ session('success')}}</p>
                        </div>
                    </div>
                </div>

            @endif

            @if(session()->has('error'))
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="notification notification-error">
                            <p class="m-0 text-bold">{{ session('error')}}</p>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
            @include('layouts.footers.auth.footer')
        </div>
    </main>

@endsection
