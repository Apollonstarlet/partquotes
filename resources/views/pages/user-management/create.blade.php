@extends('layouts.user_type.auth')

@section('content')

    <div class="col-12 col-sm-8 col-lg-6 mx-auto">
        <div class="card card-body">
            <h5 class="mb-0 mb-3">Add New User</h5>

            <form role="form text-left" method="POST" action="{{ route('user-management.store') }}">
                @csrf
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Name" name="name" id="name" aria-label="Name"
                           aria-describedby="name" value="{{ old('name') }}" autocomplete="off" spellcheck="false">
                    @error('name')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" id="email"
                           aria-label="Email"
                           aria-describedby="email-addon" value="{{ old('email') }}" autocomplete="off"
                           spellcheck="false">
                    @error('email')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password" id="password"
                           aria-label="Password" aria-describedby="password-addon" autocomplete="new-password"
                           spellcheck="false">
                    @error('password')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn bg-gradient-dark mb-2 w-100">Add User</button>
                </div>
            </form>
        </div>
    </div>

@endsection
