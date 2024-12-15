@props(['selected' => false, 'disabled' => false, 'labelextendClass' => false])
<div class='form-group mb-3 {{ $extraClass ?? '' }}'>
    <label for='{{ $id }}'
        class='word-wrap form-label text-capitalize {{ $labelextendClass ?? '' }} {{ $required ? 'required-label' : '' }}'>{{ ucfirst($label) }}
    </label>
    <select name='{{ $name ?? '' }}' id='{{ $id }}' class='{{ $class ?? '' }} form-select' {{ $attr ?? '' }}
        {{ $disabled ? 'disabled' : '' }}>
        {{ $slot }}
    </select>
    <div class='mt-1 dmsError'>
        @error($name)
            <div class='text-danger' style='font-size:10px'>{{ $message }}</div>
        @enderror
    </div>
</div>
