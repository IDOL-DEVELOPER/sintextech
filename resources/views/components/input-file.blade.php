@props(['dataType' => '', 'multiple' => ''])
<div class='form-group mb-2 position-relative {{ $extraClass }}'>
    <label class='word-wrap form-label {{ $labelextendClass }} text-capitalize {{ $required ? 'required-label' : '' }}'
        for='{{ $id ?? '' }}'>{{ ucfirst($label ?? '') }}
    </label>
    <div class='form-control custom-input fileUploadInput p-0 pointer' data-upload
        data-multiple='{{ $multiple ? 'checkbox' : 'radio' }}' data-type='{{ $dataType ? $dataType : 'image' }}'
        data-shareid='{{ $id ?? '' }}'>
        <div class='d-flex align-items-center h-100'>
            <span class='uploadSectionBrowse'>Browse</span>
            &nbsp;&nbsp;
            <div>
                <input type='{{ $type ?? 'hidden' }}' data-file-input value='{{ $value ?? '' }}'
                    name='{{ $name ?? '' }}' label=' ' id='{{ $id ?? '' }}' {{ $multiple ?? '' }}>
                <span class='font-bold' data-file-count
                    id='choosedFile-{{ $id ?? '' }}'>{{ $fileName ? $fileName : 'Choose File' }}</span>
            </div>
        </div>
    </div>
    <div class='{{ $classPreview ? $classPreview : '' }} mt-1 rounded-3 border-light border-1 border overflow-hidden position-relative previewSection p-0 {{ $src ? 'file-item' : '' }}'
        style='max-width: 150px;max-height:150px' data-preview id='previewSelectionData-{{ $id ?? '' }}'>
        @php
            $extension = strtolower(pathinfo($src ?? '', PATHINFO_EXTENSION));
        @endphp

        @if (in_array($extension, ['mp4', 'mov', 'avi', 'wmv']))
            <video loop muted autoplay style='max-height: 150px;max-width: 150px;' class='rounded-3'>
                <source src='{{ $src ?? '' }}' type='video/{{ $extension }}'>
                Your browser does not support the video tag.
            </video>
        @elseif (in_array($extension, ['pdf', 'doc', 'docx']))
            <iframe src='{{ $src ?? '' }}' class='w-100 rounded-3' style='height:150px;' frameborder='0'></iframe>
        @else
            <img src='{{ $src ? $src : asset('storage/icons/avtar.png') }}' id='previewImage-{{ $id ?? '' }}'
                class='w-100 rounded-3 fit-image' style='height: 150px'>
        @endif
        @if (isset($src) && $src != '' && $src != 0)
            <div class='position-absolute end-0 top-0'>
                <button type='button' data-close-id='{{ $id ?? '' }}' class='remove-btn' aria-label='Close'>
                    X
                </button>
            </div>
        @else
            <div class='position-absolute end-0 top-0 d-none close-btn-wrapper' id='closebtn-{{ $id ?? '' }}'>
                <button type='button' data-close-id='{{ $id ?? '' }}' class='remove-btn' aria-label='Close'>
                    X
                </button>
            </div>
        @endif
    </div>
</div>
