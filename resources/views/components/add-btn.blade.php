@access('write')
    <div class="d-flex align-items-center">
        <a href="{{ !empty($href) ? $href : '#' }}"  class="btn-none" {{ $attr ?? '' }}>
            <i class="fa fa-circle-plus text-primary fs-4"></i>
        </a>
    </div>
@endaccess
