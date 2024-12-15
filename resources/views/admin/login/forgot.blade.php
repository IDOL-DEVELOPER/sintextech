@extends('admin.layouts.app')
@section('title', 'Forgot Password')
@section('css')
    <style>
        body {
            background: url('{{ asset('storage/icons/background.svg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .list-style-none {
            list-style: none;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid vh-100 login-img">
        <div class="container d-flex justify-content-center align-items-center vh-100">
            <div class="w-100 shadow p-5 rounded mt-5 bg-white" style="max-width: 400px;">
                <div class="text-center mb-4">
                    <img src="https://play-lh.googleusercontent.com/19GU_MtEUEYBvY-TUH6IF96d8AyGYYZoeob1eDQymFXaQb9qtZADzAIFKWoYPFtDci4"
                        alt="Logo" style="width: 100px; height: 100px;">
                    <h2 class="text-center fw-bold">Forgot Password?</h2>
                    <p class="mb-4">You can reset your password here.</p>
                </div>
                <!-- Display Success Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0 list-style-none">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST" class="p-2">
                    @csrf
                    <input type="hidden" name='token' value="{{ $token->token }}">
                    <x-input type="password" name="new_password" id="new_password" label="New Password" required />
                    <x-input type="password" name="confirm_password" id="confirm_password" label="confirm password"
                        required />
                    <div class="">
                        <button class="btn btn-primary rounded-2 text-light w-100"
                            onclick="this.disabled=true; this.form.submit();" type="submit">Submit</button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
@endsection
