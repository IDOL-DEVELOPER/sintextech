@extends('admin.layouts.master')
@section('title', 'Managers')
@section('content')
    <div class="">
        <div class="mb-2 d-flex justify-content-between flex-wrap">
            <x-back />
            <x-add-btn attr="data-bs-toggle=modal data-bs-target=#openModal" />
        </div>
        <x-form-view>
            <livewire:datatables.roles-table />
        </x-form-view>
    </div>
    @access('create', 'update')
        <form action="{{ route('admin.rolesAction') }}" method="POST">
            @csrf
            <x-modal title="Roles" id="openModal">
                <x-input type="hidden" label=" " id="hidden_id" name="id" extraClass="d-none" />
                <x-input type="hidden" label=" " id="action" name="action" value="create" extraClass="d-none" />
                <x-input type="text" label="Role Name" id="roles" name="role" value="" />
            </x-modal>
        </form>
    @endaccess
@endsection
@section('script')
    @access('update')
        <script>
            function actionUpdate(id, name) {
                $("#hidden_id").val(id);
                $("#roles").val(name);
                $("#action").val("update");
                $("#openModal").modal('show');
            }
            $(document).ready(function() {
                $('#openModal').on('hidden.bs.modal', function() {
                    $("#hidden_id,#roles").val('');
                    $("#action").val("create");
                });
            });
        </script>
    @endaccess
@endsection
