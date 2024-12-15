@php
    $status = $text === 'Active' ? 'success' : 'danger';
@endphp
@access('update')
    <button class="btn btn-{{ $status ?? '' }} btn-action" {!! $attr !!}>
        {{ $text ?? '' }}
    </button>
@else
    <button class="btn btn-{{ $status ?? '' }} btn-action" disabled>
        {{ $text ?? '' }}
    </button>
@endaccess
