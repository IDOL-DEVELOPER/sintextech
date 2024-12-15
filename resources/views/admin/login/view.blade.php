@php
    $selectedLoginType = session('loginType');
@endphp
@extends('admin.layouts.app')
@section('title', 'Login')
@section('css')
    <style>
        body{
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
    <div class="container-fluid vh-100 vw-100 login-img">
        <div class="container  d-flex justify-content-center align-items-center vh-100">
            <div class="w-100 shadow p-5 rounded mt-5 bg-white" style="max-width: 400px;">
                <div class="text-center mb-4 ">
                    <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" style="width: 100px; height: 100px;">
                    <h2 class="text-center fw-bold mb-4">Login</h2>
                </div>
                @livewire('login-form')
            </div>
        </div>
    </div>
@endsection
