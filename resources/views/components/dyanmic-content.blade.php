@props(['target' => '', 'btn' => '', 'editor' => 'false'])
<div class='border-light border-1 border-dashed p-1 my-2'>
    <div id="{{ ltrim($target, '#') }}">
    </div>
    <button class="btn btn-success text-light w-100 dynamic-btn" data-editor="{{ $editor }}" type="button"
        data-content="{!! $slot ?? '' !!}" data-target="{!! $target ?? '' !!}">
        <i class="fas fa-circle-plus me-1"></i> {!! $btn ?? '' !!}
    </button>
</div>
