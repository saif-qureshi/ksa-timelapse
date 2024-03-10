<?php

namespace App\Livewire;

use App\Contracts\CrudListContract;
use App\Models\Camera;
use App\Traits\CrudListHelper;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CameraList extends Component implements CrudListContract
{
    use WithPagination, CrudListHelper;

    public string $model = Camera::class;
    public $sortField = 'id';
    public ?string $createUrl = "camera.create";
    protected string $paginationTheme = 'tailwind';

    public function buildFilters(): array
    {
        return [];
    }

    public function buildTable(): array
    {
        return [
            [
                'name' => 'Name',
                'key' => 'name',
                'sort' => true,
            ],
            [
                'name' => 'Token',
                'html' => true,
                'cb' => fn($camera) => Str::mask($camera->access_token,'*',5, 40)
            ],
            [
                'name' => 'Longitude',
                'key'   => 'longitude'
            ],
            [
                'name' => 'Latitude',
                'key'   => 'latitude'
            ],
            [
                'name'        => 'Active',
                'checkActive' => 'is_active',
            ],
            [
                'name'    => 'Action',
                'actions' => [
                    [
                        'name'  => 'Edit',
                        'icon'  => 'tick',
                        'route' => function ($camera) {
                            return route('camera.edit', $camera->id);
                        }
                    ],
                    [
                        'name'  => 'Delete',
                        'class' => 'deleteBtn text-danger',
                        'icon'  => 'dustbin',
                        'route' => function ($camera) {
                            return route('camera.destroy', $camera->id);
                        }
                    ]
                ]
            ]
        ];
    }

    public function getTableName(): string
    {
        return 'Cameras';
    }


    public function getWith(): ?string
    {
        return "";
    }

    public function getSearchOptions(): array
    {
        return [
            'enabled'      => true,
            'placeholder'  => 'Search by Name',
            'searchFields' => [
                'name',
            ]
        ];
    }

    public function hasPagination(): bool
    {
        return true;
    }

    public function getPerPageOptions(): array
    {
        return [
            'enabled' => true,
            'perPage' => 10,
        ];
    }

    public function getExtraQuery($query): ?Builder
    {
        return $query;
    }

    public function render()
    {
        return view('livewire.pages.camera-listing')
            ->with([
                'data'    => $this->filter(),
                'table'   => $this->buildTable(),
                'filters' => $this->buildFiltersWithProperties()
            ]);
    }
}
