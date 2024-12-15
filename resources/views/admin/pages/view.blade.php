@extends('admin.layouts.master')
@section('title', 'Pages')
@section('content')
    <div class="mb-2 d-flex justify-content-between flex-wrap">
        <x-back />
        <x-add-btn href="{{ route('admin.pagesForm') }}" />
    </div>
    <x-form-view>
        <livewire:datatables.pages-table/>
    </x-form-view>
@endsection
