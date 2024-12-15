<?php

namespace App\Livewire\Datatables;

use App\Models\Blog;
use App\Livewire\ConfirmModal;
use App\Models\Category;
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

final class BlogTable extends PowerGridComponent
{
    use WithExport;

    public bool $showFilters = true;
    public string $filterToggle = "hide";
    public bool $srNo = false;
    protected $listeners = ['show-alert'];
    public string $sortDirection = 'desc';
    public $status = "";


    public function setUp(): array
    {
        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount()->pageName('Blog'),
        ];
    }

    public function datasource(): Builder
    {
        if ($this->status >= 0) {
            $query = Blog::query()->where('status', $this->status);
        } else {
            $query = Blog::query();
        }
        return $query;
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('title', fn($c) => '<p class="blogContent p-0 m-0" >' . getFirst50Words($c->title) . '</p>' ?? 'N/A')
            ->add('content', fn($c) => '<p class="blogContent m-0" >' . getFirst50Words($c->content) . '</p>' ?? 'N/A')
            ->add('slug')
            ->add('brief', fn($c) => '<p class="blogContent m-0" >' . getFirst50Words($c->brief) . '</p>' ?? 'N/A')
            ->add('views')
            ->add('likes')
            ->add('tags')
            ->add('image_id')
            ->add('auth_id', fn($a) => $a->createdBy())
            ->add('instance_created')
            ->add('meta_key')
            ->add('meta_title', fn($c) => '<p class="blogContent m-0" >' . getFirst50Words($c->meta_title) . '</p>' ?? 'N/A')
            ->add('meta_desc', fn($c) => '<p class="blogContent m-0" >' . getFirst50Words($c->meta_desc) . '</p>' ?? 'N/A')
            ->add('status', fn($status) => $this->renderToggleButton($status));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')->index(),
            Column::make('Title', 'title')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),
            Column::make('Views', 'views')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),
            Column::make('Likes', 'likes')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),
            Column::make('Title', 'title')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),
            Column::make('Brief', 'brief')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),
            Column::make('Tags', 'tags')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),

            Column::make('Post By', 'auth_id')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),
            Column::make('Web Post', 'instance_created')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),

            Column::make('Meta keywords', 'meta_key')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),

            Column::make('Meta title', 'meta_title')
                ->sortable()
                ->searchable()->visibleInExport(visible: true),

            Column::make('Meta description', 'meta_desc')
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
        $filters = [];
        if ($this->status == "") {
            $filters[] = Filter::boolean('status')->label('Published', 'Draft');
        }       
        return $filters;
    }

    public function actions(Blog $row): array
    {
        $buttons = [];
        $onclickValue = htmlspecialchars("`{$row->id}`", ENT_QUOTES);
        if (user()->hasPermission('update')) {
            $buttons[] = Button::add('edit')
                ->bladeComponent('update-btn', ["href" => route('admin.blogForm', ['slug' => $row->slug])]);
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

    public function toggleStatus($Blog_id)
    {
        try {
            $Blog = Blog::findOrFail($Blog_id);
            $Blog->status = !$Blog->status;
            $Blog->save();
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return response()->json(["error" => "Something Went Wrong"]);
        }
    }
    private function renderToggleButton($Blog)
    {
        $statusClass = $Blog->status == 1 ? 'success' : 'danger';
        $statusText = $Blog->status == 1 ? 'Published' : 'In Draft';
        $attr = 'wire:click="toggleStatus(' . $Blog->id . ')"';
        return view('components.multi-status-btn', [
            'status' => $statusClass,
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
            $callDelete = Blog::findOrFail($rowId);
            if ($relCheck && $callDelete->product()->exists()) {
                $route = "kvbishnoi";
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
