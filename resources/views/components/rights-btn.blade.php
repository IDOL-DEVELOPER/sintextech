<a href="{{ !empty($href) ? $href : '#' }}"  class="btn btn-warning text-light btn-action" {!! !empty($href) ? '' : 'onclick="actionUpdate(' . ($attr ?? '') . ')"' !!}>
    <i class="fa fa-lock" title="Edit"></i>&nbsp;Rights
</a>
