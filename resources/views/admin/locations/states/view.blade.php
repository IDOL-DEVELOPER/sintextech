@extends('admin.layouts.master')
@section('title', 'States')
@section('content')
    <div class="">
        <div class="mb-2 d-flex justify-content-between flex-wrap">
            <x-back />
            <x-add-btn attr="data-bs-toggle=modal  data-bs-target=#openModal" />
        </div>
        <x-form-view>
            <livewire:datatables.states-table />
        </x-form-view>
    </div>
    @access('write', 'update')
        <form action="{{ route('admin.statesAction') }}" method="POST">
            <x-modal id="openModal" title="States">
                @csrf
                <x-input type='hidden' name="action" value="create" label="action" placeholder="action" id="action" old
                    extraClass="d-none" />
                <x-input type='hidden' name="id" label="taxRateID" placeholder="id" attr="data-scn" id="vtypeID" old
                    extraClass="d-none" />
                <x-select id="country" label="countries" class="cms" name="country" required>
                    <x-option text="Select Country" selected />
                    @foreach ($countries as $country)
                        <x-option value="{{ $country->id }}" text="{{ $country->name }}" />
                    @endforeach
                </x-select>
                <x-input type='text' name="state_name" label="State Name" placeholder="State Name" id="state" old
                    required />
            </x-modal>
        </form>
    @endaccess
@endsection
@section('script')
    @access('update')
        <script>
            function actionUpdate(id, country, state) {
                $("#vtypeID").val(id);
                $("#state").val(state);
                $("#action").val("update");
                $("#openModal").modal('show');
                $("#country")
                    .val(country)
                    .trigger("chosen:updated");
            }
            $(document).ready(function() {
                $('#openModal').on('hidden.bs.modal', function() {
                    $("#vtypeID").val("");
                    $("#state").val('');
                    $("#action").val("create");
                    $("#country")
                        .val("")
                        .trigger("chosen:updated");
                });

            });
        </script>
    @endaccess
@endsection
