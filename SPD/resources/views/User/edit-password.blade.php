@extends('layouts.app')

@section('title', 'Edit Password')

@section('content')
    <div class="pagetitle">
        <h1>Edit Password</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Data Users</a></li>
                <li class="breadcrumb-item active">Edit Password</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                {{-- <h5 class="card-title">Edit Password for {{ $user->first_name . ' ' . $user->last_name }}</h5> --}}
                <h5 class="card-title">Edit Password for {{ $user->username }}</h5>
                <form action="{{ route('users.updatePassword', $user) }}" method="POST">
                    @csrf
                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePasswordConfirm">
                                <i class="bi bi-eye-slash" id="togglePasswordConfirmIcon"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle visibility for the password field
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                togglePasswordIcon.classList.toggle('bi-eye');
                togglePasswordIcon.classList.toggle('bi-eye-slash');
            });

            // Toggle visibility for the password confirmation field
            const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const togglePasswordConfirmIcon = document.getElementById('togglePasswordConfirmIcon');

            togglePasswordConfirm.addEventListener('click', function() {
                const type = passwordConfirmInput.type === 'password' ? 'text' : 'password';
                passwordConfirmInput.type = type;
                togglePasswordConfirmIcon.classList.toggle('bi-eye');
                togglePasswordConfirmIcon.classList.toggle('bi-eye-slash');
            });
        });
    </script>
@endsection
