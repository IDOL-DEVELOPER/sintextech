<?php

namespace App\Livewire\Datatables;

use App\Models\Comments;
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

final class CommentsTable extends PowerGridComponent
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
                ->showRecordCount()->pageName('Comments'),
        ];
    }

    public function datasource(): Builder
    {
        return Comments::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('comment')
            ->add('likes');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Comment', 'comment')
                ->sortable()
                ->searchable(),

            Column::make('Likes', 'likes'),
            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
               Filter::inputText('name')->placeholder('Name'),
               Filter::boolean('status')->label('Active', 'Deactive')
        ];
    }

  public function actions(Comments $row): array
    {
        $buttons = [];
        $onclickValue = htmlspecialchars("`{$row->id}`", ENT_QUOTES);
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

  public function toggleStatus($Comments_id)
    {
     try {
            $Comments = Comments::findOrFail($Comments_id);
            $Comments->status = !$Comments->status;
            $Comments->save();
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return response()->json(["error" => "Something Went Wrong"]);
        }
    }
    private function renderToggleButton($Comments)
    {
        $statusClass = $Comments->status == 1 ? 'success' : 'danger';
        $statusText = $Comments->status == 1 ? 'Active' : 'Block';
        $attr = 'wire:click="toggleStatus(' . $Comments->id . ')"';
        return view('components.status-btn', [
            'st' => $Comments->$statusClass,
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
            $callDelete =  Comments::findOrFail($rowId);
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
