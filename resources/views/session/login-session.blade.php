{{-- layout --}}
@extends('layouts.auth')

{{-- page title --}}
@section('title','Login')

{{-- page style --}}
@section('page-style')
@endsection

{{-- page content --}}
@section('content')

    <div class="authentication-wrapper authentication-cover">
      <!-- Logo -->
      <a href="{{asset('/')}}" class="auth-cover-brand d-flex align-items-center gap-2">
        <span class="app-brand-logo demo">
        </span>
        <span class="app-brand-text demo text-heading fw-bold">Mopart</span>
      </a>
      <!-- /Logo -->
      <div class="authentication-inner row m-0">
        <!-- /Left Section -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-5 pb-2">
          <img
            src="{{asset('assets/img/illustrations/auth-login-illustration-light.png')}}"
            class="auth-cover-illustration w-100"
            alt="auth-illustration"
            data-app-light-img="illustrations/auth-login-illustration-light.png"
            data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
          <img
            src="{{asset('assets/img/illustrations/auth-cover-login-mask-light.png')}}"
            class="authentication-image"
            alt="mask"
            data-app-light-img="illustrations/auth-cover-login-mask-light.png"
            data-app-dark-img="illustrations/auth-cover-login-mask-dark.png" />
        </div>
        <!-- /Left Section -->

        <!-- Login -->
        <div
          class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
          <div class="w-px-400 mx-auto pt-5 pt-lg-0">
            <h4 class="mb-2 fw-semibold">Welcome to Mopart! 👋</h4>
            <p class="mb-4">Please sign-in to your account.</p>

            <form id="formAuthentication" class="mb-3" action="/session" method="POST">
              @csrf
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus />
                <label for="email">Email</label>
              </div>
              <div class="mb-3">
                <div class="form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                      <label for="password">Password</label>
                    </div>
                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                  </div>
                </div>
              </div>
              <div class="mb-3 d-flex justify-content-between">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me" checked="" />
                  <label class="form-check-label" for="remember-me"> Remember Me </label>
                </div>
                
              </div>
              <button class="btn btn-primary d-grid w-100">Sign in</button>
            </form>

            <p class="text-center mt-2">
              <span>New on our platform?</span>
              <a href="{{asset('register')}}">
                <span>Create an account</span>
              </a>
            </p>
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>
  
@endsection