@props(['disabled' => false])
<div class='form-group mb-3 w-100 position-relative {{ $extraClass }}'>
    <label class='word-wrap  form-label {{ $labelextendClass }} text-capitalize {{ $required ? 'required-label' : '' }} '
        for='{{ $id }}'>{{ ucfirst($label) }}
    </label>
    <textarea name='{{ $name }}' id='{{ $id }}' cols='{{ $cols }}' rows='{{ $rows }}'
        class='form-control {{ $class }}' placeholder='{{ $placeholder }}' {{ $attr }}
        {{ $disabled ? 'disabled' : '' }}>{{ old($name, $value) }}</textarea>
    <div class='error_message text-danger' style='font-size:10px'></div>
    <div class='mt-1'>
        @error($name)
            <div class='text-danger' style='font-size:10px'>{{ $message }}</div>
        @enderror
    </div>
</div>
