
    <div class="d-flex align-items-center">
        <a href="{{ !empty($href) ? $href : '#' }}" class="btn-none {{ $class ?? '' }} " {{ $attr ?? '' }}>
            <i class="{{ $icon ?? 'fas fa-icons' }} {{ $color ?? 'text-primary' }} fs-4" {{ $target ?? '' }}></i>
        </a>
    </div>
