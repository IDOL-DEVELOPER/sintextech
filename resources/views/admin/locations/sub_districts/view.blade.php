@extends('admin.layouts.master')
@section('title', 'Sub Districts')
@section('content')
    <div class="">
        <div class="mb-2 d-flex justify-content-between flex-wrap">
            <x-back />
            <x-add-btn attr="data-bs-toggle=modal  data-bs-target=#openModal" />
        </div>
        <x-form-view>
            <livewire:datatables.sub-districts-table />
        </x-form-view>
    </div>
    @access('write', 'update')
        <form action="{{ route('admin.subDistrictsAction') }}" method="POST">
            <x-modal id="openModal" title="Sub Districts">
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
                <x-select id="district" label="District" attr="data-districts" class="cms" name="district" required>
                    <x-option text="Select District" selected />
                </x-select>
                <x-input type='text' name="sub_district_name" label="Sub District Name" placeholder="Sub District Name"
                    id="sub_district" old required />
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
                $("[data-state]").on("change", function() {
                    let id = $(this).val();
                    fetchDistricts(id, "{{ route('admin.districtsFetch') }}");
                });
            });
        </script>
    @endaccess
    @access('update')
        <script>
            function actionUpdate(id, country, state, district, name) {
                $("#vtypeID").val(id);
                $("#sub_district").val(name);
                $("#action").val("update");
                $("#openModal").modal('show');
                $("#country")
                    .val(country)
                    .trigger("chosen:updated");
                fetchState(country, "{{ route('admin.statesFetch') }}", state);
                fetchDistricts(state, "{{ route('admin.districtsFetch') }}", district);
            }
            $(document).ready(function() {
                $('#openModal').on('hidden.bs.modal', function() {
                    $("#vtypeID").val("");
                    $("#sub_district").val('');
                    $("#action").val("create");
                    $("#country")
                        .val("")
                        .trigger("chosen:updated");
                    $("#state").empty().append('<option value="" selected>Select State</option>').trigger(
                        "chosen:updated");
                    $("#district").empty().append('<option value="" selected>Select District</option>').trigger(
                        "chosen:updated");
                });

            });
        </script>
    @endaccess
@endsection
