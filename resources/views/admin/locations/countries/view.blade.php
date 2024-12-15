@extends('admin.layouts.master')
@section('title', 'Countries')
@section('content')
    <div class="">
        <div class="mb-2 d-flex justify-content-between flex-wrap">
            <x-back />
            <x-add-btn attr="data-bs-toggle=modal  data-bs-target=#openModal" />
        </div>
        <x-form-view>
            <livewire:datatables.countries-table/>
        </x-form-view>
    </div>
    @access('write', 'update')
        <form action="{{ route('admin.countriesAction') }}" method="POST">
            <x-modal id="openModal" title="Countries">
                @csrf
                <x-input type='hidden' name="action" value="create" label="action" placeholder="action" id="action" old
                    extraClass="d-none" />
                <x-input type='hidden' name="id" label="taxRateID" placeholder="id" attr="data-scn" id="vtypeID" old
                    extraClass="d-none" />
                <x-input type='text' name="name" label="Name" placeholder="Name" id="countries" old
                    required />
            </x-modal>
        </form>
    @endaccess
@endsection
@section('script')
    @access('update')
        <script>
            function actionUpdate(id, country) {
                $("#vtypeID").val(id);
                $("#countries").val(country);
                $("#action").val("update");
                $("#openModal").modal('show');

            }
            $(document).ready(function() {
                $('#openModal').on('hidden.bs.modal', function() {
                    $("#vtypeID").val("");
                    $("#countries").val("");
                    $("#action").val("create");
                });

            });
        </script>
    @endaccess
@endsection
