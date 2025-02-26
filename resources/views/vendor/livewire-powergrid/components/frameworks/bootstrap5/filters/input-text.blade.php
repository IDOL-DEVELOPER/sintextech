@props([
    'theme' => '',
    'enabledFilters' => [],
    'column' => null,
    'inline' => null,
    'filter' => null,
])
<div>
    @php
        $fieldClassName = data_get($filter, 'className');
        $field = strval(data_get($filter, 'field'));
        $title = strval(data_get($column, 'title'));
        $operators = (array) data_get($filter, 'operators', []);
        $placeholder = strval(data_get($filter, 'placeholder'));
        $componentAttributes = (array) data_get($filter, 'attributes', []);

        $inputTextOptions = $fieldClassName::getInputTextOperators();
        $inputTextOptions = count($operators) > 0 ? $operators : $inputTextOptions;
        $showSelectOptions = !(count($inputTextOptions) === 1 && in_array('contains', $inputTextOptions));

        $defaultPlaceholder = data_get($column, 'placeholder') ?: data_get($column, 'title');
        $overridePlaceholder = $placeholder ?: $defaultPlaceholder;

        unset($filter['placeholder']);

        $defaultAttributes = $fieldClassName::getWireAttributes($field, $title);

        $selectClasses = \Illuminate\Support\Arr::toCssClasses(['power_grid', data_get($theme, 'selectClass')]);
        $inputClasses = \Illuminate\Support\Arr::toCssClasses(['power_grid', data_get($theme, 'inputClass')]);

        $params = array_merge(
            [
                'showSelectOptions' => $showSelectOptions,
                'placeholder' => ($placeholder = $componentAttributes['placeholder'] ?? $overridePlaceholder),
                ...data_get($filter, 'attributes'),
                ...$defaultAttributes,
            ],
            $filter,
        );
    @endphp

    @if ($params['component'])
        @unset($params['operators'], $params['attributes'])

        <x-dynamic-component :component="$params['component']" :attributes="new \Illuminate\View\ComponentAttributeBag($params)" />
    @else
        <div class="{{ data_get($theme, 'baseClass') }}" style="{{ data_get($theme, 'baseStyle') }}">
            @if ($showSelectOptions)
                {{-- <div class="relative">
                <select
                    class="cms"
                    style="{{ data_get($column, 'headerStyle') }}"
                    {{ $defaultAttributes['selectAttributes'] }}
                >
                    @foreach ($inputTextOptions as $key => $value)
                        <option
                            wire:key="input-text-options-{{ $tableName }}-{{ $key . '-' . $value }}"
                            value="{{ $value }}"
                        >{{ trans('livewire-powergrid::datatable.input_text_options.' . $value) }}</option>
                    @endforeach
                </select>
            </div> --}}
            @endif
            <div class="me-1 mb-1 mb-md-0">
                <input wire:key="input-{{ $field }}" data-id="{{ $field }}"
                    @if (isset($enabledFilters[$field]['disabled']) && boolval($enabledFilters[$field]['disabled']) === true) disabled
                        @else
                            {{ $defaultAttributes['inputAttributes'] }} @endif
                    type="text" class="form-control form-control-sm tb-rounded" placeholder="{{ $placeholder }}" />
            </div>
        </div>
    @endif
</div>
