<?php

namespace App\Livewire;

use App\Models\Developer;
use App\Contracts\CrudListContract;
use App\Traits\CrudListHelper;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class DeveloperList extends Component implements CrudListContract
{
    use WithPagination, CrudListHelper;

    public string $model = Developer::class;
    public $sortField = 'id';
    public ?string $createUrl = "developer.create";
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
                'html' => true,
                'cb' => fn ($developer) => view('livewire.partials.developer-name-column', compact('developer'))
            ],
            [
                'name'        => 'Created At',
                'html'        => true,
                'cb'          => fn ($developer) => $developer->created_at->format('M d, Y, g:i A')
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
                        'route' => function ($developer) {
                            return route('developer.edit', $developer->id);
                        }
                    ],
                    [
                        'name'  => 'Delete',
                        'class' => 'deleteBtn text-danger',
                        'icon'  => 'dustbin',
                        'route' => function ($developer) {
                            return route('developer.destroy', $developer->id);
                        }
                    ]
                ]
            ]
        ];
    }

    public function getTableName(): string
    {
        return 'Developer';
    }


    public function getWith(): ?string
    {
        return "";
    }

    public function getSearchOptions(): array
    {
        return [
            'enabled'      => true,
            'placeholder'  => 'Search by Name or tag',
            'searchFields' => [
                'name',
                'tag'
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
        return $query->FilterByRole(auth()->user());
    }
}
