@extends('admin.layouts.master')
@section('title', 'Blogs')
@section('content')
    <style>
        p img {
            display: none !important
        }

        p {
            width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <div class="">
        <div class="mb-2 d-flex justify-content-between flex-wrap">
            <x-back />
            <x-add-btn href="{{ route('admin.blogForm') }}" />
        </div>
        <x-form-view>
            <livewire:datatables.blog-table status="1" />
        </x-form-view>
    </div>
@endsection
