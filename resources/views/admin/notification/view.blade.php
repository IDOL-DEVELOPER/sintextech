@extends('admin.layouts.master')
@section('title', 'Notifications')
@section('content')
    <div class="">
        <div class="mb-2 d-flex justify-content-between flex-wrap">
            <x-back />
        </div>
        <x-form-view>
            <livewire:datatables.notification-table/>
        </x-form-view>
    </div>
@endsection
