@extends('layouts.user_type.auth')

@section('content')

    <div class="col-12 col-sm-8 col-lg-6 mx-auto">
        <div class="card card-body">
            <h5 class="mb-0 mb-3">Update User</h5>

            <form method="POST" action="{{ route('user-management.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Name" name="name" id="name" aria-label="Name"
                           aria-describedby="name" value="{{ $user->name }}" autocomplete="off" spellcheck="false">
                    @error('name')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" id="email"
                           aria-label="Email"
                           aria-describedby="email-addon" value="{{ $user->email }}" autocomplete="off"
                           spellcheck="false"
                           @if($user->isAdmin()) readonly @endif
                    >
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
                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Update User</button>
                </div>
            </form>
        </div>
    </div>

@endsection
