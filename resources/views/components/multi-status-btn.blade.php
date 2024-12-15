@access('update')
    <a href="{{ !empty($href) ? $href : '#' }}" 
        class="btn btn-{{ $status }} btn-action text-light text-capitalize" {{ $target ?? '' }}
        {!! isset($attr) && empty($href) ? $attr : '' !!}>
        <i class="{{ $icon ?? '' }}"></i>{{ $text ?? '' }}
    </a>
@else
    <a href="{{ !empty($href) ? $href : '#' }}" 
        class="btn btn-{{ $status }} btn-action text-light text-capitalize" disabled>
        <i class="{{ $icon ?? '' }}"></i>{{ $text ?? '' }}
    </a>
@endaccess
