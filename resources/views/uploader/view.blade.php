<div class="modal fade" id="KVUploaderModal" data-uploadModal data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable card-rounded p-0" role="document">
        <div class="modal-content h-100 border-none card-rounded p-0 m-0 overflow-hidden">
            <div class="modal-header pb-0 bg-light d-flex flex-wrap justify-content-between bg-primary">
                <div class="kvModal">
                    <ul class="d-flex nav">
                        <li class=" me-3 p-2 rounded-2 rounded-bottom-none border border-bottom-none"
                            id="select-parent">
                            <a class="tabUpload text-light active decoration-none font-bold text-decoration-none fs-14"
                                id="select-tab" data-uploadCheck="select" data-bs-toggle="tab" href="#KV-select-file"
                                role="tab" aria-controls="KV-select-file" aria-selected="true">Select File</a>
                        </li>
                        <li class="me-3 p-2 rounded-2 rounded-bottom-none border border-bottom-none">
                            <a class="tabUpload text-light font-bold text-decoration-none fs-14" id="new-tab"
                                data-uploadCheck="upload" data-bs-toggle="tab" href="#KV-upload-new" role="tab"
                                aria-controls="KV-upload-new" aria-selected="true">Upload Files</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex judtify-content-between align-items-center">
                    <label class="btn btn-success btn-sm d-none" for="addMoreFiles" id="add-more-files"><i
                            class="fa fa-plus"></i>Add More
                        Files
                        <input type="file" class="d-none" id="addMoreFiles" name="files[]" multiple>
                    </label>
                </div>
                {{-- <button type="button" class="btn-close p-0 m-0" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
          
            <div class="modal-body">
                <div class="tab-content h-100">
                    <div class="tab-pane h-100 show active" id="KV-select-file" role="tabpanel"
                        aria-labelledby="select-tab">
                        <!-- Content for selecting files -->
                        <div class="KV-uploader-filter pt-1 pb-3 border-bottom mb-4">
                            <div class="row align-items-center gutters-5 gutters-md-10 position-relative">
                                {{-- <div class="col-xl-2 col-md-3 col-5">
                                    <div class="">
                                        <!-- Input -->
                                        <select class="form-control form-control-xs KV-selectpicker cms"
                                            name="KV-uploader-sort">
                                            <option value="newest" selected>Sort By Newest</option>
                                            <option value="oldest">Sort by Oldest</option>
                                            <option value="smallest">Sort by Smallest</option>
                                            <option value="largest">Sort by Largest</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-md-4 col-xl-3 ml-auto position-static">
                                    <div class="KV-uploader-search text-right">
                                        <input type="text" class="form-control form-control-xs"
                                            name="KV-uploader-search" oninput="fetchFiles('',this.value)"
                                            placeholder="Search your files">
                                        <i class="search-icon d-md-none"><span></span></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="KV-uploader-all clearfix c-scrollbar-light">
                            <div class="align-items-center d-flex h-100 w-100">
                                <div id="filesListShow" class="row w-100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane h-100" id="KV-upload-new">
                        <!-- File Upload Section -->
                        <div id="dropZone" class="h-100 d-flex align-items-center justify-content-center  border-light">
                            <div class="text-center">
                                <h2>File Upload</h2>
                                <label for="fileInput" id="file-drag">
                                    <div class="drop-zone  border-light">
                                        <div class="text-center">
                                            <i class="fas fa-download fa-5x"></i>
                                        </div>
                                        <div>Select a file or drag here</div>
                                        <p class="text-danger me-1 text-center fs-10">Note: Only Allow {{ setting('max_file_size') }}KB Max
                                            File
                                            Size For Upload.</p>
                                        <input type="file" class="d-none" id="fileInput" name="files[]" multiple>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div id="file-list" class="d-flex flex-wrap"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between bg-dark">
                <div class="w-100">
                    <div id="progressbar" class="d-none">
                        <div class="progress-wrapper mb-1">
                            <div id="progress-bar"></div>
                        </div>
                        <div class="d-flex position-relative">
                            <div id="loading-circle"></div>&nbsp;&nbsp;
                            <span id="uploadedData">0 KB</span>/
                            <span class="font-bold me-1" id="totalSizeDataForUpload">0 MB</span>
                            ||&nbsp;&nbsp;
                            <p id="remainingTime">0s</p>
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1 overflow-hidden d-flex">
                    <div class="d-flex flex-wrap w-100 align-items-center">
                        <div class="KV-uploader-selected font-bold me-2" id="file-count">0 File selected</div>
                        <span>||</span>&nbsp;
                        <span class="font-bold me-1" id="totalSize">Total Size: 0 MB</span>
                        <button type="button" class="btn-link btn btn-sm p-0 KV-uploader-selected-clear"
                            id="images-clear">Clear All</button>
                    </div>
                    {{-- <div class="mb-0 ml-3">
                        <button type="button" class="btn btn-sm btn-primary" id="uploader_prev_btn">Prev</button>
                        <button type="button" class="btn btn-sm btn-primary" id="uploader_next_btn">Next</button>
                    </div> --}}
                </div>
                <x-close-btn />
                <button type="button" class="btn btn-primary w-100" onclick="uploadFiles()" id="uploadFilesBtn"
                    data-toggle="KVUploaderAddSelected">Add Files</button>
            </div>
        </div>
    </div>
</div>
<x-modal title="Image Preview" btnClass="d-none" class="modal-dialog-centered" id="previewImageUploader">
    <div class="preview-content card-rounded overflow-hidden"></div>
</x-modal>
