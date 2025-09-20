@extends('layouts.app')

@section('title', 'Data Users')

@section('content')
    <div class="pagetitle">
        <h1>Data Users</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Users</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('error') }}
        </div>
    @endif
    <section class="section">

        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Users</h5>
                        <div class="mb-3">
                            <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bi bi-plus-square">
                                    Create New User</i></a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center">NO</th>
                                        <th scope="col" class="text-center">ID Card Number</th>
                                        <!--<th scope="col" class="text-center">Username</th>-->
                                        <th scope="col" class="text-center">Name</th>
                                        <th scope="col" class="text-center">Role</th>
                                        <th scope="col" class="text-center">Last Login</th>
                                        <th scope="col" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $user->id_card_number }}</td>
                                            <!--<td class="text-center">{{ $user->username }}</td>-->
                                            <td class="text-center">{{ $user->first_name . ' ' . $user->last_name }}</td>
                                            <td class="text-center">{{ $user->role }}</td>
                                            <td class="text-center">
                                                @if ($user->last_login && \Carbon\Carbon::parse($user->last_login)->isValid())
                                                    {{ \Carbon\Carbon::parse($user->last_login)->diffForHumans() }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($user->role === 'viewer') <!-- Tambahkan kondisi untuk role viewer -->
                                                <a href="{{ route('users.editPassword', $user) }}" class="btn btn-warning btn-sm mt-2">
                                                    <i class="bi bi-key"></i>
                                                </a>
                                                <!--&nbsp;|&nbsp;-->
                                            @endif
                                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                    id="delete-form-{{ $user->id }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $user->id }})"
                                                        class="btn btn-danger btn-sm mt-2">
                                                        <i class="bi bi-trash3"></i> Delete
                                                    </button>
                                                </form>
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
    </section>
@endsection
