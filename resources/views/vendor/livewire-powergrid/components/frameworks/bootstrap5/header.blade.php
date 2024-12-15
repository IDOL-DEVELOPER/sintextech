<div>
    @includeIf(data_get($setUp, 'header.includeViewOnTop'))
    <div class="dt--top-section">
        <div class="row">
            <div class="col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center flex-wrap">
                @include(powerGridThemeRoot() . '.header.actions')

                <div class="me-1">
                    @includeWhen(data_get($setUp, 'exportable'), powerGridThemeRoot() . '.header.export')
                </div>
                @if (filled(data_get($setUp, 'footer.perPage')) && count(data_get($setUp, 'footer.perPageValues')) > 1)
                    <div class="d-flex flex-lg-row align-items-center">
                        <label class="w-auto">
                            <select wire:model.live="setUp.footer.perPage"
                                class="form-select form-select-sm {{ data_get($theme, 'footer.selectClass') }} tb-rounded"
                                style="{{ data_get($theme, 'footer.selectStyle') }}">
                                @foreach (data_get($setUp, 'footer.perPageValues') as $value)
                                    <option value="{{ $value }}">
                                        @if ($value == 0)
                                            {{ trans('livewire-powergrid::datatable.labels.all') }}
                                        @else
                                            {{ $value }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        {{-- <small class="ms-2 text-muted">
                        {{ trans('livewire-powergrid::datatable.labels.results_per_page') }}
                    </small> --}}
                    </div>
                @endif
                @include(powerGridThemeRoot() . '.header.toggle-columns')
                @includeIf(powerGridThemeRoot() . '.header.soft-deletes')
                <button wire:click="toggleFilter" class="btn btn-light mx-1 {{ $showFilters ? 'd-block' : 'd-none' }}">
                    <i class="fa fa-filter"></i>
                    </button>
                    @include(powerGridThemeRoot() . '.header.enabled-filters')
                    @include(powerGridThemeRoot() . '.header.multi-sort')
                @includeWhen(boolval(data_get($setUp, 'header.wireLoading')),
                    powerGridThemeRoot() . '.header.loading')
            </div>
            <div class="col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3">
                @include(powerGridThemeRoot() . '.header.search')
                </div>
            <div class="mt-1 d-flex flex-wrap justify-content-center tbfilter {{ $filterToggle }}">
                @if ($showFilters && $this->hasColumnFilters)
                    @include('livewire-powergrid::components.inline-filters')
                @endif
            </div>
        </div>
    </div>
    @include(powerGridThemeRoot() . '.header.batch-exporting')
    @includeIf(data_get($setUp, 'header.includeViewOnBottom'))
    @includeIf(powerGridThemeRoot() . '.header.message-soft-deletes')
</div>
