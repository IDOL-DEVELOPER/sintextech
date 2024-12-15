@extends('admin.layouts.master')
@section('title', 'Upload')
@section('content')
    <x-back class="mb-2" />
    <x-form-view title="Uploads">
        <div class="d-flex flex-wrap w-100 align-items-center">
            @access('delete')
                <div class="d-flex align-items-center">
                    <label for="checkAll" class="font-bold mt-1 custom-checkbox-label position-relative me-4">
                        <input type="checkbox" class="custom-checkbox d-none" id="checkAll" />&nbsp;
                        <span class="checkbox-custom me-3">
                        </span>
                    </label>
                    <label for="checkAll" class="mt-2">
                        <span class="font-bold">
                            Select All
                        </span>
                    </label>
                </div>
            @endaccess
            @access('update')
                <button id="showAttr" class="btn btn-warning text-light ms-auto me-2"><i
                        class="fas fa-eye"></i>&nbsp;&nbsp;Show
                    Image Attr</button>
                <div class="submit-attr-container">

                </div>
            @endaccess
            @access('delete')
                <button id="bulkDeleteBtn" class="btn btn-danger text-light me-2"><i class="fas fa-trash"></i>&nbsp;&nbsp;Bulk
                    Delete</button>
            @endaccess
            @access('create')
                <button class="btn btn-primary text-light" onclick="uploadModalFn()"><i
                        class="fas fa-plus"></i>&nbsp;&nbsp;Upload
                    File</button>
            @endaccess
        </div>
        <hr>
        <div class="row px-3">
            @foreach ($uploads as $item)
                <div class="col-md-4 col-lg-3 col-6 mb-2">
                    <div class="file-item bg-dark shadow p-2 card-rounded overflow-hidden position-relative"
                        data-file-id="{{ $item->id }}">
                        @access('delete')
                            <label class="position-absolute start-0 top-0 pointer custom-checkbox-label position-relative"
                                for="file-{{ $item->id }}">
                                <input type="checkbox" class="custom-checkbox filesForSelection d-none"
                                    id="file-{{ $item->id }}" value="{{ $item->id }}" name="file-selec" />
                                <span class="checkbox-custom mangaeFromTop"></span>
                            </label>
                        @endaccess
                        <div class="position-absolute top-0 bg-white p-2 pointer rounded-circle d-flex align-items-center justify-content-center shadow"
                            type="button" id="dropdownMenuButton-{{ $item->id }}" data-bs-toggle="dropdown"
                            data-bs-target="dropdownInfo-{{ $item->id }}" aria-expanded="false"
                            style="right:4px;width:25px;height:25px">
                            <i class="fas fa-ellipsis-vertical text-primary fs-10"></i>
                        </div>
                        <ul class="dropdown-menu" id="dropdownInfo-{{ $item->id }}"
                            aria-labelledby="dropdownMenuButton-{{ $item->id }}">
                            <li
                                onclick="uploadInfo('{{ $item->original_name }}','{{ $item->createdBy() }}','{{ $item->file_size }}','{{ $item->external_link }}','{{ $item->type }}')">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-info-circle me-2"></i> Info</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ asset($item->external_link) }}" download> <i
                                        class="fas fa-download me-2"></i> Download</a></li>
                            <li><a class="dropdown-item" href="#" data-copy="{{ asset($item->external_link) }}"> <i
                                        class="fas fa-copy me-2"></i> Copy Link
                                </a></li>
                            @access('delete')
                                <li><a class="dropdown-item" href="#" onclick="deleteUpload({{ $item->id }})"> <i
                                            class="fas fa-trash me-2"></i> Delete
                                    </a></li>
                            @endaccess
                        </ul>
                        @php
                            $fileType = pathinfo($item->file_name, PATHINFO_EXTENSION);
                        @endphp
                        @if ($item->type == 'image')
                            <div class="file-preview w-100" style="height: 80%">
                                <img src="{{ $item->external_link }}" alt="Image preview"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @elseif($item->type == 'video')
                            <!-- Display video -->
                            <div class="file-preview w-100" style="height:80%;">
                                <video src="{{ $item->external_link }}" controls
                                    style="width: 100%; height: 100%;object-fit: cover;"></video>
                            </div>
                        @else
                            <div class="file-preview" style="height:80%;">
                                <div class="d-flex h-100 justify-content-center align-items-center">
                                    <Span class="font-bold">No Preview Avaiable</Span>
                                </div>
                            </div>
                        @endif
                        <div class="text-start w-100 position-absolute bottom-0 px-1">
                            <div class="text-turncate">
                                <span class="text-dark font-bold">{{ getFirst50Words($item->original_name) }}</span>
                            </div>
                            <p class="m-0 p-0">{{ $item->file_size }}</p>
                        </div>
                        <div class="position-absolute bottom-0 bg-csub w-100 p-0 attr-upload" style="display: none">
                            <x-input name="attr[{{ $item->id }}]" extendClass="attr-value" value="{{$item->attr}}" extraClass="mb-0 mbb-0"
                                id="upload-attr-{{ $item->id }}" label="Image Attriute" type="text" />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pagination d-flex w-100 justify-content-end">
            {{ $uploads->links() }}
        </div>
    </x-form-view>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasUploadInfo" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header bg-primary">
            <h5 class="offcanvas-title text-light" id="offcanvasRightLabel"> Upload Info</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body off-sidebar">
            <x-input name="original_name" value="" extraClass="" label="Original Name" id="originalName"
                type="text" disabled />
            <x-input name="created_by" value="" extraClass="" label="Created By" id="createdBy" type="text"
                disabled />
            <x-input name="file_size" value="" extraClass="" label="File Size" id="fileSize" type="text"
                disabled />
            <x-input name="type" value="" extraClass="" label="Type" id="type" type="text"
                disabled />
            <div class="text-center py-3">
                <a href="" id="externalLink" class="btn btn-primary" download>Download</a>
            </div>
        </div>
    </div>
    @access('delete')
        <form id="bulkDeleteForm" action="{{ route('upload.action') }}" method="POST" style="display: none;">
            @csrf
            <x-input name="action" value="delete" extraClass="d-none" label=" " id="actionfordelete"
                type="text" />
            <input type="hidden" name="file" id="bulkDeleteFiles" />
        </form>
    @endaccess
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            @access('update')
            const attrUploadDiv = $('.attr-upload');

            // Show/hide attributes and append the submit button
            $('#showAttr').on('click', function() {
                    if (attrUploadDiv.is(':visible')) {
                        // Hide the attributes
                        attrUploadDiv.hide();
                        $('#submitAttr').remove(); // Remove the submit button if it exists
                        $('#showAttr').html('<i class="fas fa-eye"></i>&nbsp;&nbsp;Show Image Attr');
                    } else {
                        // Show the attributes
                        attrUploadDiv.show();
                        $('#showAttr').html('<i class="fas fa-eye-slash"></i>&nbsp;&nbsp;Hide Image Attr');

                        // Create and append the Submit button if it doesn't exist
                        if ($('#submitAttr').length === 0) {
                            const submitButton = $('<button>', {
                                id: 'submitAttr',
                                class: 'btn btn-success text-light ms-auto me-2',
                                html: '<i class="fas fa-paper-plane"></i>&nbsp;&nbsp;Submit Attr'
                            });

                            // Append the submit button inside the submit-attr-container
                            $('.submit-attr-container').append(submitButton);

                            // Submit button click event
                            submitButton.on('click', function() {
                                    let attrValues = {};

                                    // Sabhi input fields ko select karna
                                    $('.attr-value').each(function() {
                                        let value = $(this).val().trim();
                                        if (value !== '') {
                                            attrValues[$(this).attr('name')] = value;
                                        }
                                    });
                                    console.log(attrValues);

                                    // AJAX request to submit attribute values
                                    $.ajax({
                                            url: '{{ route('upload.action') }}', // Update with your route name
                                            type: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                                attributes: attrValues,
                                                action: 'attr'
                                            },
                                            success: function(response) {
                                                alertshow(response.error, response.message);
                                                if (response.error == 'false'){
                                                    attrUploadDiv.hide();
                                                $('#showAttr').html(
                                                    '<i class="fas fa-eye"></i>&nbsp;&nbsp;Show Image Attr'
                                                );
                                                submitButton
                                                    .remove();
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                           alert('something went wrong')
                                        }
                                    });
                            });
                    }
                }
            }); @endaccess


        // Check/Uncheck all checkboxes
        $('#checkAll').on('change', function() {
            $('.filesForSelection').prop('checked', $(this).prop('checked'));
            $(".file-item").removeClass("active");
            $(".filesForSelection:checked").each(function() {
                $(this).closest(".col-lg-2").find(".file-item").addClass("active");
            });
        }); @access('delete')
        // Bulk delete
        $('#bulkDeleteBtn').on('click', function() {
            let selectedFiles = $('.filesForSelection:checked').map(function() {
                return $(this).val();
            }).get();
            if (selectedFiles.length === 0) {
                alert('Please select at least one file.');
                return;
            }
            if (confirm('Are you sure you want to delete the selected files?')) {
                $('#bulkDeleteFiles').val(JSON.stringify(selectedFiles));
                $('#bulkDeleteForm').submit();
            }
        }); @endaccess
        });
        @access('create')

        function uploadModalFn() {
            uploadModal.modal('show');
            $('#KV-select-file,#select-tab,#select-parent').css('display', 'none');
            $('#select-tab').removeClass('active');
            $('#KV-select-file,#select-tab,#select-parent').css('display', 'none');
            $('#new-tab,#KV-upload-new').addClass('active new')
        }
        $(".filesForSelection").on("change", function() {
            $(".file-item").removeClass("active");
            $(".filesForSelection:checked").each(function() {
                $(this).closest(".col-lg-2").find(".file-item").addClass("active");
            });
        });

        function deleteUpload(ids) {
            let deleteIDs = Array.isArray(ids) ? ids : [ids];
            $('#bulkDeleteFiles').val(JSON.stringify(deleteIDs));
            $('#bulkDeleteForm').submit();
        }
        @endaccess

        function uploadInfo(originalName, createdBy, fileSize, externalLink, type) {
            document.getElementById('originalName').value = originalName;
            document.getElementById('createdBy').value = createdBy;
            document.getElementById('fileSize').value = fileSize;
            let externalLinkElement = document.getElementById('externalLink');
            externalLinkElement.href = externalLink;
            document.getElementById('type').value = type;

            // Open the off-canvas menu
            var offcanvasElement = document.getElementById('offcanvasUploadInfo');
            var offcanvas = new bootstrap.Offcanvas(offcanvasElement);
            offcanvas.show();
        }
    </script>
@endsection
