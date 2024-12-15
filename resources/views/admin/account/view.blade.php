@extends('admin.layouts.master')
@section('title', 'Account')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 p-1">
                <div class="bg-csub shadow card-rounded overflow-hidden">
                    <div class="p-2 bg-primary">
                        <span class="text-light fs-6  font-bold word-wrap">Basic Details</span>
                    </div>
                    <hr class="p-0 m-0">
                    <div class="container my-2">
                        <form action="{{ route('admin.updateAccount') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="text-center">
                                <div id="profileContainer"
                                    class="image-input image-input-outline image-input-circle image-input-empty">
                                    <div class="profile-progress"></div>
                                    <img id="profileImage" class="image-input-wrapper w-125px h-125px"
                                        src="{{ asset('storage/' . auth()->user()->image) }}"
                                        onerror="this.src='{{ asset('storage/icons/avtar.png') }}'">
                                    <label class="btn btn-icon circle bg-body shadow d-flex align-items-center justify-content-center" data-bs-toggle="modal"
                                        data-bs-target="#optionsModal" data-kt-image-input-action="change"
                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Change avatar" style="width:30px;height:30px;transform: translate(-100%, 0)!important" >
                                        <i class="fas fa-pencil-alt text-primary"></i>
                                    </label>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip" title=""
                                        data-bs-original-title="Remove avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                </div>
                            </div>
                            <x-input value="{{ auth()->user()->name }}" id="nameuser" label='FullName' name='name'
                                type='text' extendClass='text-dark ' labelextendClass='text-dark' attr="data-scn" />
                            <x-input id="emailuser" value="{{ auth()->user()->email }}" label="email" name="email"
                                type="email" extendClass="text-dark " />
                            <x-input id="phone" label='Phone No.' value='{{ auth()->user()->phone }}' name='phone'
                                type='number' extendClass='text-dark ' labelextendClass='text-dark' />
                            <x-textarea id="address" name="address" value="{{ auth()->user()->address }}" label="address">
                                {{ auth()->user()->address }}
                            </x-textarea>
                            <div class="pb-3">
                                <button class="w-100 btn btn-primary btn-rounded"
                                    onclick="this.disabled=true; this.form.submit();" type="submit">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-1">
                <div class="card-rounded bg-csub shadow overflow-hidden">
                    <div class="p-2 bg-primary">
                        <span class="text-light fs-6  font-bold word-wrap">Change Password</span>
                    </div>
                    <hr class="p-0 m-0">
                    <div class="container my-2">
                        <form action="{{ route('admin.updatePassword') }}" method="POST">
                            @csrf
                            <x-input id="currentpassword" label='Current Password' name='current_password' type='password'
                                extendClass='text-dark ' labelextendClass='text-dark' />
                            <x-input id="password" label="New Password" name="new_password" type="password"
                                extendClass="text-dark " labelextendClass="text-dark" />
                            <x-input id="confirm_password" label='Confirm Password' name='confirm_password' type='password'
                                extendClass='text-dark ' labelextendClass='text-dark' />
                            <div class="pb-3">
                                <button class="w-100 btn btn-primary btn-rounded"
                                    onclick="this.disabled=true; this.form.submit();" type="submit" name="save">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var token = $('meta[name="csrf-token"]').attr("content");
        (() => {
            const disableElement = function(e, x) {
                if (!(e instanceof jQuery)) e = $(e);
                e.attr("disabled", true);
                const html = x ?
                    '<div class="absolute-preloader" ><div class="preloader-message" ><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please Wait...</div></div>' :
                    '<div class="absolute-preloader" ><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div>';
                e.append(html).css({
                    position: "relative",
                    opacity: ".5",
                    cursor: "not-allowed",
                });
            };

            const enableElement = (e) => {
                if (!(e instanceof jQuery)) e = $(e);
                e.attr("disabled", false);
                e.find(".absolute-preloader").remove();
                e.css({
                    opacity: "1",
                    cursor: "pointer",
                });
            };

            const fileChooser = $("input[type=file]#fileChooser");
            const cropModal = $("#cropModal");
            const optionsModal = $("#optionsModal");
            const cropArea = $("#cropimage");
            const profileImage = $("#profileImage");
            cropModal.on("hide.bs.modal", () => {
                cropArea.html('<img id="imageprev" src=""/>');
            });
            $("[data-bs-dismiss='modal']").on("click", function() {
                $(".modal").modal("hide");
            });

            fileChooser.on("change", (e) => {
                optionsModal.modal("hide");
                cropModal.modal("show");
                var image = document.querySelector("#imageprev");
                var files = e.target.files;
                var done = function(url) {
                    e.target.value = "";
                    image.src = url;
                    cropModal.modal({
                        backdrop: "static",
                    });
                    cropImage();
                };
                var reader;
                var file;
                var url;
                if (files && files.length > 0) {
                    file = files[0];
                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function(e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            $(document).on("click", "#saveAvatar", function(event) {
                const t = $(this);
                event.preventDefault();
                const progress = $(".progress");
                const progressBar = $(".progress-bar");
                canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400,
                });
                progress.show();
                canvas.toBlob(function(blob) {
                    const formData = new FormData();
                    formData.append("image", blob, "avatar.jpg");
                    formData.append("_token", token);
                    formData.append("instance", '{{ auth()->user()->instance() }}');
                    formData.append("id", '{{ auth()->user()->id }}');
                    $.ajax("{{ route('admin.saveImage') }}", {
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            disableElement(t);
                        },
                        xhr: function() {
                            const xhr = new XMLHttpRequest();
                            xhr.upload.onprogress = function(e) {
                                let percent = "0";
                                let percentage = "0%";
                                if (e.lengthComputable) {
                                    percent = Math.round((e.loaded / e.total) * 100);
                                    percentage = percent + "%";
                                    progressBar
                                        .width(percentage)
                                        .attr("aria-valuenow", percent)
                                        .text(percentage);
                                }
                            };
                            return xhr;
                        },
                        success: function(res) {
                            try {
                                alertshow(res.error, res.message);
                                cropModal.modal("hide");
                                const url = res.url;
                                progress.hide();
                                profileImage.attr("src", url);
                            } catch (e) {}
                        },
                        error: function(error) {
                            alertshow(true, error);
                            console.log(error);
                        },
                        complete: function() {
                            enableElement(t);
                        },
                    });
                });
            });

            $("#editProfile").on("click", (e) => {
                $.ajax({
                    url: "{{ route('admin.fetchImage') }}",
                    type: "POST",
                    data: {
                        instance: '{{ user()->instance() }}',
                        _token: token,
                        id: '{{ auth()->user()->id }}',
                    },
                    beforeSend: function() {
                        disableElement(e.currentTarget);
                    },
                    success: function(res) {
                        try {
                            const url = res;
                            cropArea.html('<img id="imageprev" src="' + url + '" />');
                            optionsModal.modal("hide");
                            cropModal.modal("show");
                            cropModal.modal({
                                backdrop: "static",
                            });
                            cropImage();
                        } catch (e) {
                            console.log(e);
                        }
                    },
                    error: function(e) {
                        alertshow(true, e);
                        console.log(e);
                    },
                    complete: function() {
                        enableElement(e.currentTarget);
                    },
                });
            });

            // Webcamera
            const webCamModal = $("#webCamModal");

            $("#openWebCamModal").on("click", function(event) {
                event.preventDefault();
                optionsModal.modal("hide");
                webCamModal.modal("show");
            });

            $("#spanshot").on("click", function(event) {
                event.preventDefault();
                take_snapshot();
                webCamModal.modal("hide");
            });

            function configure() {
                Webcam.set({
                    width: 640,
                    height: 480,
                    image_format: "jpeg",
                    jpeg_quality: 100,
                });
                Webcam.attach("#webCameraArea");
            }

            function take_snapshot() {
                Webcam.snap(function(data_uri) {
                    webCamModal.modal("hide");
                    cropModal.modal({
                        backdrop: "static",
                    });
                    cropArea.html('<img id="imageprev" src="' + data_uri + '"/>');
                    cropImage();
                });
                Webcam.reset();
            }

            webCamModal.on("show.bs.modal", function() {
                configure();
            });

            //
            webCamModal.on("hide.bs.modal", function() {
                Webcam.reset();
                cropModal.modal("show");
                cropArea.html('<img id="imageprev" src=""/>');
            });

            // CROP IMAGE AFTER UPLOAD
            var cropper;

            function cropImage() {
                var image = document.querySelector("#imageprev");
                // $(image).on("load", () => {
                setTimeout(() => {
                    var minAspectRatio = 1;
                    var maxAspectRatio = 1;
                    cropper = new Cropper(image, {
                        aspectRatio: 1,
                        autoCropArea: 1,
                        minCropBoxWidth: 150,
                        minCropBoxHeight: 150,
                        ready: function() {
                            var cropper = this.cropper;
                            var containerData = cropper.getContainerData();
                            var cropBoxData = cropper.getCropBoxData();
                            var aspectRatio = cropBoxData.width / cropBoxData.height;
                            var newCropBoxWidth;
                            cropper.setDragMode("move");
                            if (
                                aspectRatio < minAspectRatio ||
                                aspectRatio > maxAspectRatio
                            ) {
                                newCropBoxWidth =
                                    cropBoxData.height *
                                    ((minAspectRatio + maxAspectRatio) / 2);
                                console.log(newCropBoxWidth);
                                cropper.setCropBoxData({
                                    left: (containerData.width - newCropBoxWidth) / 2,
                                    width: newCropBoxWidth,
                                });
                            }
                        },
                    });
                }, 500);

                $("#scaleY").click(function() {
                    var Yscale = cropper.imageData.scaleY;
                    if (Yscale == 1) {
                        cropper.scaleY(-1);
                    } else {
                        cropper.scaleY(1);
                    }
                });
                $("#scaleX").click(function() {
                    var Xscale = cropper.imageData.scaleX;
                    if (Xscale == 1) {
                        cropper.scaleX(-1);
                    } else {
                        cropper.scaleX(1);
                    }
                });
                $("#rotateR").click(function() {
                    cropper.rotate(45);
                });
                $("#rotateL").click(function() {
                    cropper.rotate(-45);
                });
                $("#reset").click(function() {
                    cropper.reset();
                });
            }
        })();
    </script>
@endsection
