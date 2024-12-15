<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
    integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css"
    integrity="sha512-0nkKORjFgcyxv3HbE4rzFUlENUMNqic/EzDIeYCgsKa/nwqr2B91Vu/tNAu4Q0cBuG4Xe/D1f/freEci/7GDRA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- fontawesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- editor --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" referrerpolicy="no-referrer" />
{{-- perfetc scrollb --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.5/css/perfect-scrollbar.min.css">
{{-- timepicker --}}
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css"
    crossorigin="anonymous">
{{-- custom css --}}
<style>
    :root {
        --primary: {{ setting('primary-color') ? setting('primary-color') : '#0DCAF0' }};
        --btn-raduis: {{ setting('btn-radius') ? setting('btn-radius') : '0' }};
        --card-raduis: {{ setting('card-radius') ? setting('card-radius') : '0' }};
        --border-radius-menu: {{ setting('border-radius-menu') ? setting('border-radius-menu') : '5px' }};
    }
</style>
<link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/new.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/responsive.css') }}">
<link rel="stylesheet" href="{{ asset('css/uploader.css') }}">
<link rel="stylesheet" href="{{ asset('css/cropper.css') }}">
@livewireStyles
@yield('css')
