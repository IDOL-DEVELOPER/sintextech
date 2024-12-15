@props(['accept' => '', 'min'])
<div class='form-group mb-2  position-relative {{ $extraClass ?? 'w-100' }}'>
    <label class='word-wrap form-label {{ $labelextendClass }} text-capitalize {{ $required ? 'required-label' : '' }}  '
        for='{{ $id }}'>{{ ucfirst($label) }}
    </label>
    <input type='{{ $type ?? 'text' }}' min='{{ $min ?? '' }}'
        class='form-control custom-input {{ $errors->has($name) ? 'is-invalid' : '' }} {{ $extendClass }}'
        name='{{ $name }}' id='{{ $id }}' value='{{ old($name, $value) }}'
        placeholder='{{ $placeholder }}' autocomplete='off' {{ $attr }} {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }} accept='{{ $accept }}'>
    @if ($type === 'password')
        <div class='position-absolute pointer icon-password-show p-1' data-password-show={{ $id }}><i
                class='fa fa-eye text-primary float-end'></i></div>
    @endif
    <div class='error_message text-danger position-absolute' style='font-size:10px'>
    </div>
    <div class='mt-1 dmsError'>
        @error($name)
            <div class='text-danger' style='font-size:10px'>{{ $message }}</div>
        @enderror
    </div>
</div>
