<div class="modal fade" id="optionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered rounded-2">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <span class="text-dark font-bold">Profile Image</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input class="sr-only" id="fileChooser" type="file" name="avatar"
                    accept=".png, .jpg, .jpeg">
                <label for="fileChooser" class="btn btn-primary btn-sm"><i class="fa fa-file"></i></label>
                <button id="openWebCamModal" class="btn btn-warning btn-sm text-light"><i
                        class="fa fa-camera"></i></button>
                <button id="editProfile" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="webCamModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg ">
        <div class=" modal-content">
            <div class="modal-header d-flex justify-content-between">
                <span class="text-dark font-bold">Take a picture</span>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="black"></rect>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body">
                <div id="webCameraArea"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" id="spanshot">Take a picture</button>
                <button type="button" class="btn btn-secondary btn-rounded"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cropModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class=" modal-content">
            <div class="modal-header justify-content-between">
                <span class="text-dark font-bold">Profile Image</span>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="black"></rect>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body">
                <div id="cropimage">
                    <img id="imageprev" src="" />
                </div>

                <div class="progress mt-6">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <div class="d-flex">
                    <button type="button" class="btn btn-light-primary btn-sm" id="rotateL"
                        title="Rotate Left">
                        <i class="fas fa-undo"></i></button>
                    <button type="button" class="ms-2 btn btn-light-primary btn-sm" id="rotateR"
                        title="Rotate Right">
                        <i class="fas fa-repeat"></i>
                    </button>
                    <button type="button" class="ms-2 btn btn-light-primary btn-sm" id="scaleX"
                        title="Flip Horizontal">
                        <i class="fa fa-arrows-h"></i>
                    </button>
                    <button type="button" class="ms-2 btn btn-light-primary btn-sm" id="scaleY"
                        title="Flip Vertical">
                        <i class="fa fa-arrows-v"></i>
                    </button>
                    <button type="button" class="ms-2 btn btn-light-primary btn-sm" id="reset"
                        title="Reset">
                        <i class="fas fa-refresh"></i>
                    </button>
                </div>
                <div class="d-flex">
                    <button type="button" class="me-2 btn btn-dark float-right" id="saveAvatar">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>

    </div>
</div>