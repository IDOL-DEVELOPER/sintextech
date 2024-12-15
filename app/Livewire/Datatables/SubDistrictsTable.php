<?php

namespace App\Livewire\Datatables;

use App\Models\SubDistricts;
use App\Livewire\ConfirmModal;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class SubDistrictsTable extends PowerGridComponent
{
    use WithExport;

    public bool $showFilters = true;
    public string $filterToggle = "hide";
    public bool $srNo = false;
    protected $listeners = ['show-alert'];
    public string $sortDirection = 'desc';
    public function setUp(): array
    {
        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount()->pageName('SubDistricts'),
        ];
    }

    public function datasource(): Builder
    {
        return SubDistricts::query()
            ->with('district');
    }

    public function relationSearch(): array
    {
        return [
            "district" => [
                'name',
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('did', fn($SubDistricts) => $SubDistricts->district->name ?? 'N/A')
            ->add('state', fn($SubDistricts) => $SubDistricts->district->state->name ?? 'N/A')
            ->add('country', fn($SubDistricts) => $SubDistricts->district->state->country->name ?? 'N/A')
            ->add('status', fn($status) => $this->renderToggleButton($status));
    }

    public function columns(): array
    {
        return [
            Column::make('S.No', 'id')->index(),

            Column::make('Country', 'country')
                ->searchable()->visibleInExport(visible: true),
            Column::make('State', 'state')
                ->searchable()->visibleInExport(visible: true),
            Column::make('District', 'did')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),
            Column::make('Sub District Name', 'name')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),
            Column::make('Status', 'status')->visibleInExport(visible: false),
            Column::action('Action')->visibleInExport(visible: false)
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->placeholder('Sub District Name'),
            Filter::boolean('status')->label('Active', 'Deactive')
        ];
    }

    public function actions(SubDistricts $row): array
    {
        $buttons = [];
        $onclickValue = htmlspecialchars("`".($row->id ?? '')."`,`".($row->district->state->country->id ?? '' )."`,`".($row->district->state->id ?? '')."`,`".($row->did ?? '')."`,`".($row->name ?? '')."`", ENT_QUOTES);
        if (user()->hasPermission('update')) {
            $buttons[] = Button::add('edit')
                ->bladeComponent('update-btn', ["attr" => $onclickValue]);
        }
        if (user()->hasPermission('delete')) {
            $buttons[] = Button::add('delete')
                ->bladeComponent('delete-btn', [
                    "attr" => "wire:click=delete($row->id)",
                    "extra" => "wire:confirm",
                ]);
        }
        return $buttons;
    }

    public function toggleStatus($SubDistricts_id)
    {
        try {
            $SubDistricts = SubDistricts::findOrFail($SubDistricts_id);
            $SubDistricts->status = !$SubDistricts->status;
            $SubDistricts->save();
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return response()->json(["error" => "Something Went Wrong"]);
        }
    }
    private function renderToggleButton($SubDistricts)
    {
        $statusClass = $SubDistricts->status == 1 ? 'success' : 'danger';
        $statusText = $SubDistricts->status == 1 ? 'Active' : 'Block';
        $attr = 'wire:click="toggleStatus(' . $SubDistricts->id . ')"';
        return view('components.status-btn', [
            'st' => $SubDistricts->$statusClass,
            'text' => $statusText,
            'attr' => $attr,
        ])->render();
    }
    public function toggleFilter()
    {
        $this->filterToggle = $this->filterToggle === 'show' ? 'hide' : 'show';
    }
    #[\Livewire\Attributes\On('delete')]
    public function delete($rowId)
    {
        $relCheck = false;
        try {
            $callDelete = SubDistricts::findOrFail($rowId);
            if ($relCheck && $callDelete->product()->exists()) {
                $route = "dms.taxRatesAction";
                $dispatch = $this->dispatch("showModal", ["id" => $rowId, "route" => $route,])->to(ConfirmModal::class);
                return;
            }
            $callDelete->delete();
            $this->js("alertshow(false,'Record Delete Successfully')");
        } catch (\Throwable $th) {
            ce($th->getMessage());
            $this->js("alertshow(true,'something Went Wrong')");
        }
    }
}
