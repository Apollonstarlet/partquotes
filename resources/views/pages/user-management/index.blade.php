@extends('layouts.user_type.auth')

@section('content')

    <div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">

                            <h5 class="mb-0">All Users</h5>

                            <a href="{{ route('user-management.create') }}" class="btn bg-gradient-dark mb-2"
                               type="button">Add New User</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                        Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                        Role
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                        Created
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-bold mb-0">{{ $user->name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-bold mb-0">{{ $user->email }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-bold mb-0">{{ ucfirst($user->role) }}</p>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="text-secondary text-sm font-weight-bold">{{ $user->created_at?->format('d/m/Y') }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('user-management.edit', $user->id) }}" class="mx-3"
                                               data-bs-toggle="tooltip"
                                               data-bs-original-title="Edit user">
                                                <i class="fas fa-user-edit text-secondary"></i>
                                            </a>
                                            <span>
                                                <form id="delete-form-{{ $user->id }}"
                                                      action="{{ route('user-management.destroy', $user->id) }}"
                                                      method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <a href="#"
                                                   onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-original-title="Delete user"
                                                >
                                                    <i class="cursor-pointer fas fa-trash-alt text-secondary"></i>
                                                </a>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
