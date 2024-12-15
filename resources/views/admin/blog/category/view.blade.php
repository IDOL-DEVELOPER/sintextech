@extends('admin.layouts.master')
@section('title', 'Blogs')
@section('content')
    <div class="">
        <div class="mb-2 d-flex justify-content-between flex-wrap">
            <x-back />
            <x-add-btn attr="data-bs-toggle=modal  data-bs-target=#openModal" />
        </div>
        <x-form-view>
            <livewire:datatables.categories-table-blog />
        </x-form-view>
    </div>
    @access('write', 'update')
        <form action="{{ route('admin.blogCategoryAction') }}" method="POST">
            <x-modal id="openModal" title="Blog Category">
                @csrf
                <x-input type='hidden' name="action" value="create" label="action" placeholder="action" id="action" old
                    extraClass="d-none" />
                <x-input type='hidden' name="id" label=" " placeholder="id" attr="data-scn" id="id" old
                    extraClass="d-none" />
                <x-input type='text' name="name" label="category name" placeholder="category name" id="category_name" old
                    required />
            </x-modal>
        </form>
    @endaccess
@endsection
@section('script')
    @access('update')
        <script>
            function actionUpdate(id, name) {
                $("#id").val(id);
                $("#category_name").val(name);
                $("#action").val("update");
                $("#openModal").modal('show');

            }
            $(document).ready(function() {
                $('#openModal').on('hidden.bs.modal', function() {
                    $("#id").val("");
                    $("#category_name").val("");
                    $("#action").val("create");
                });
            });
        </script>
    @endaccess
@endsection
