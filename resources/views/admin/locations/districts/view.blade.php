@extends('admin.layouts.master')
@section('title', 'Districts')
@section('content')
    <div class="">
        <div class="mb-2 d-flex justify-content-between flex-wrap">
            <x-back />
            <x-add-btn attr="data-bs-toggle=modal  data-bs-target=#openModal" />
        </div>
        <x-form-view>
            <livewire:datatables.district-table />
        </x-form-view>
    </div>
    @access('write', 'update')
        <form action="{{ route('admin.districtsAction') }}" method="POST">
            <x-modal id="openModal" title="Districts">
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
                <x-select id="state" label="States" attr="data-state" class="cms" name="state" required>
                    <x-option text="Select States" selected />
                </x-select>
                <x-input type='text' name="district_name" label="District Name" placeholder="District Name" id="district"
                    old required />
            </x-modal>
        </form>
    @endaccess
@endsection
@section('script')
    @access('write', 'update')
        <script>
            $(document).ready(function() {
                $("#country").on("change", function() {
                    let id = $(this).val();
                    fetchState(id, "{{ route('admin.statesFetch') }}");
                });
            });
        </script>
    @endaccess
    @access('update')
        <script>
            function actionUpdate(id, state, country, district) {
                $("#vtypeID").val(id);
                $("#district").val(district);
                $("#action").val("update");
                $("#openModal").modal('show');
                $("#country")
                    .val(country)
                    .trigger("chosen:updated");
                fetchState(country, "{{ route('admin.statesFetch') }}", state);
            }
            $(document).ready(function() {
                $('#openModal').on('hidden.bs.modal', function() {
                    $("#vtypeID").val("");
                    $("#district").val('');
                    $("#action").val("create");
                    $("#country")
                        .val("")
                        .trigger("chosen:updated");
                    $("#state").empty().append('<option value="" selected>Select State</option>').trigger(
                        "chosen:updated");
                });

            });
        </script>
    @endaccess
@endsection
