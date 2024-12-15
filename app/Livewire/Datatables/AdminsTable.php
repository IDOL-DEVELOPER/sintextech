<?php

namespace App\Livewire\Datatables;

use App\Models\Admin;
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

final class AdminsTable extends PowerGridComponent
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
                ->showRecordCount()->pageName('Admin'),
        ];
    }


    public function datasource(): Builder
    {
        return Admin::query()
            ->whereNot('id', '=', auth()->user()->id);
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
            ->add('email')
            ->add('role', fn($model) => $model->roles->name ?? 'N/a')
            ->add('status', fn($status) => $this->renderToggleButton($status));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')->index(),
            Column::make('Role', 'role')->visibleInExport(visible: true),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),

            Column::make('Mobile', 'phone')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),
            Column::make('Address', 'address')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),
            Column::make('Status', 'status')
                ->sortable()
                ->searchable()->visibleInExport(visible: false),
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

    public function actions(Admin $row): array
    {
        $buttons = [];
        $onclickValue = htmlspecialchars("`" . ($row->id ?? '') . "`,`" . ($row->name ?? '') . "`,`" . ($row->email ?? '') . "`,`" . ($row->phone ?? '') . "`,`" . ($row->city ?? '') . "`,`" . ($row->state ?? '') . "`,`" . ($row->zip ?? '') . "`,`" . ($row->address ?? '') . "`,`" . ($row->role ?? '') . "`", ENT_QUOTES);
        if (user()->hasPermission('rights')) {
            $buttons[] = Button::add('right')
                ->bladeComponent('rights-btn', ["href" => route('admin.adminPermissionView', ['id' => $row->ids])]);
        }
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

    public function toggleStatus($Admin_id)
    {
        try {
            $Admin = Admin::findOrFail($Admin_id);
            $Admin->status = !$Admin->status;
            $Admin->save();
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return response()->json(["error" => "Something Went Wrong"]);
        }
    }
    private function renderToggleButton($Admin)
    {
        $statusClass = $Admin->status == 1 ? 'success' : 'danger';
        $statusText = $Admin->status == 1 ? 'Active' : 'Block';
        $attr = 'wire:click="toggleStatus(' . $Admin->id . ')"';
        return view('components.status-btn', [
            'st' => $Admin->$statusClass,
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
            $callDelete = Admin::findOrFail($rowId);
            if ($callDelete->id == user()->id()) {
                $this->js("alertshow(true,'You cannot delete your own account.')");
                return;
            }
            if ($callDelete->dflt == 1) {
                $this->js("alertshow(true,'Default admin cannot be deleted.')");
                return;
            }

            if ($relCheck && $callDelete->product()->exists()) {
                $route = "kvbishnoi";
                $dispatch = $this->dispatch("showModal", ["id" => $rowId, "route" => $route,])->to(ConfirmModal::class);
                return;
            }
            //$callDelete->delete();
            $this->js("alertshow(false,'Record Delete Successfully')");
        } catch (\Throwable $th) {
            ce($th->getMessage());
            $this->js("alertshow(true,'something Went Wrong')");
        }
    }
}
