<div class="modal fade" {{ $attr }} id="{{ $id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="{{ $class }} modal-dialog card-rounded p-0">
        <div class="border-none modal-content card-rounded p-0 m-0 ">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-csub">
                {{ $slot }}
            </div>
            <div class="modal-footer bg-dark {{ $classFooter }}">
                <x-submit-btn class="{{ $btnClass ?? '' }}" :validNot="$validNot" btnName="{{ $btnName }}" />
                <x-close-btn />
            </div>
        </div>
    </div>
</div>
