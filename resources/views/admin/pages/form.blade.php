@extends('admin.layouts.master')
@section('title', 'Pages')
@section('content')
    <x-back class="mb-2" />
    <x-form-view title="Pages">
        <form action="{{ route('admin.pagesAction') }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    @csrf
                    <x-input type="hidden" label="id" name="id" value="{{ $page->id }}" extraClass="d-none"
                        old />
                    <x-input type="hidden" extraClass="d-none" value="{{ $page->id ? 'update' : 'create' }}" label="action"
                        name="action" />
                    <div class="row">
                        <div class="col-md-6">
                            <x-input type="text" attr="data-slug-make" name="name" value="{{ $page->name ?? '' }}"
                                id="name" label="name" required />
                        </div>
                        <div class="col-md-6">
                            <x-input type="text" name="slug" attr="data-slug" value="{{ $page->slug ?? '' }}"
                                id="slug" label="slug" required />
                        </div>
                        <div class="">
                            <x-textarea label="content" id="content" type="text" value="{!! $page->content !!}"
                                name="content" required />
                        </div>
                    </div>
                    <div class="w-100">
                        <x-submit-btn class="w-100" />
                    </div>
                </div>
            </div>
        </form>
    </x-form-view>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            initializeSummernote('#content');
        });
    </script>
@endsection
