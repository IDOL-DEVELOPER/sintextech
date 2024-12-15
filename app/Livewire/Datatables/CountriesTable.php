<?php

namespace App\Livewire\Datatables;

use App\Models\Countries;
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

final class CountriesTable extends PowerGridComponent
{
    use WithExport;

    public bool $showFilters = false;
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
                ->showRecordCount()->pageName('Countries'),
        ];
    }

    public function datasource(): Builder
    {
        return Countries::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('status', fn($Products) => $this->renderToggleButton($Products));
    }

    public function columns(): array
    {
        return [
            Column::make('S.No', 'id')->index(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),

            Column::make('Status', 'status')->visibleInExport(visible: false),

            Column::action('Action')->visibleInExport(visible: false)
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->placeholder('Name'),
            Filter::boolean('status')->label('Active', 'Deactive')
        ];
    }

    public function actions(Countries $row): array
    {
        $buttons = [];
        $onclickValue = htmlspecialchars("`" . ($row->id ?? '') . "`,`" . ($row->name ?? '') . "`", ENT_QUOTES);
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

    public function toggleStatus($Countries_id)
    {
        try {
            $Countries = Countries::findOrFail($Countries_id);
            $Countries->status = !$Countries->status;
            $Countries->save();
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return response()->json(["error" => "Something Went Wrong"]);
        }
    }
    private function renderToggleButton($Countries)
    {
        $statusClass = $Countries->status == 1 ? 'success' : 'danger';
        $statusText = $Countries->status == 1 ? 'Active' : 'Block';
        $attr = 'wire:click="toggleStatus(' . $Countries->id . ')"';
        return view('components.status-btn', [
            'st' => $Countries->$statusClass,
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
        $relCheck = true;
        try {
            $callDelete = Countries::findOrFail($rowId);
            if ($relCheck && $callDelete->states()->exists()) {
                $route = "dms.countriesAction";
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
