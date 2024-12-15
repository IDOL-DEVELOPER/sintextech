<a href="{{ !empty($href) ? $href : '#' }}" class="btn text-light btn-action btn-info"
    {!! !empty($href) ? '' : 'onclick="actionUpdate(' . ($attr ?? '') . ')"' !!}>
    <i class="fa fa-edit" title="Edit"></i>&nbsp;Update
</a>
