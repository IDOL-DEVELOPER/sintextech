@props(['text', 'value','attr','selected' => false])
<option value='{{ $value ?? '' }}' {{ $selected ? 'selected' : '' }} {{ $attr ?? '' }}>
    {{ $text ?? '' }}</option>
