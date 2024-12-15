@extends('admin.layouts.master')
@section('title', 'Managers')
@section('content')
    <div class="">
        <div class="mb-2 d-flex justify-content-between flex-wrap">
            <x-back />
            <x-add-btn attr="data-bs-toggle=modal data-bs-target=#openModal" />
        </div>
        <x-form-view>
            <livewire:datatables.admins-table />
        </x-form-view>
    </div>
    @access('create', 'update')
        <form action="{{ route('admin.adminsAction') }}" method="POST">
            @csrf
            <x-input type="hidden" label=" " id="hidden_id" name="id" extraClass="d-none" />
            <x-input type="hidden" label=" " id="action" name="action" value="create" extraClass="d-none" />
            <x-modal title="Managers" id="openModal" class="modal-xl">
                <div class="row">
                    <div class="col-md-4">
                        <x-select class="cms" name="role" id="role" label="role">
                            <x-option text="Select Role" />
                            @foreach ($roles as $role)
                                <x-option text="{{ $role->name }}" value="{{ $role->id }}" />
                            @endforeach
                        </x-select>
                    </div>
                    <div class="col-md-4">
                        <x-input type="text" name="name" attr="data-scn" id="admin_name" placeholder="Name" label="name"
                            required />
                    </div>
                    <div class="col-md-4">
                        <x-input type="email" name="email" id="admin_email" placeholder="Email" label="email" required />
                    </div>
                    <div class="col-md-4">
                        <x-input type="password" name="password" id="admin_password" placeholder="Password" attr="data-pass"
                            label="password" required />
                    </div>
                    <div class="col-md-4">
                        <x-input type="text" name="mobile" id="admin_mobile" attr="data-type=int" placeholder="Mobile No"
                            label="mobile no." />
                    </div>
                    <div class="col-md-4">
                        <x-textarea type="text" cols="1" rows="1" name="address" id="admin_address"
                            placeholder="Address" label="address" required></x-textarea>
                    </div>
                </div>
            </x-modal>
        </form>
    @endaccess
@endsection
@section('script')
    @access('update')
        <script>
            function actionUpdate(id, name, email, mobile, city, state, zip, address,roles) {
                $("#hidden_id").val(id);
                $("#admin_name").val(name);
                $("#admin_email").val(email);
                $("#admin_mobile").val(mobile);
                $("#admin_address").val(address);
                $("#admin_state").val(state);
                $("#admin_city").val(city);
                $("#admin_zip_code").val(zip);
                $("#role")
                    .val(roles)
                    .trigger("chosen:updated");
                $("#action").val("update");
                $("#openModal").modal('show');
            }
            $(document).ready(function() {
                $('#openModal').on('hidden.bs.modal', function() {
                    $("#hidden_id,#admin_name, #admin_email, #admin_mobile, #admin_address, #admin_state, #admin_city, #admin_zip_code")
                        .val('');
                    $("#action").val("create");
                });
            });
        </script>
    @endaccess
@endsection
