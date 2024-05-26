<?php

namespace App\Livewire;

use App\Contracts\CrudListContract;
use App\Models\Project;
use App\Traits\CrudListHelper;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectList extends Component implements CrudListContract
{
    use WithPagination, CrudListHelper;

    public string $model = Project::class;
    public $sortField = 'id';
    public ?string $createUrl = "project.create";
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
                'cb' => fn ($project) => view('livewire.partials.project-name-column', compact('project'))
            ],
            [
                'name'        => 'Developer',
                'html'        => true,
                'cb'          => fn ($developer) => $developer->developer->name,
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
                        'route' => function ($project) {
                            return route('project.edit', $project->id);
                        }
                    ],
                    [
                        'name'  => 'Delete',
                        'class' => 'deleteBtn text-danger',
                        'icon'  => 'dustbin',
                        'route' => function ($project) {
                            return route('project.destroy', $project->id);
                        }
                    ]
                ]
            ]
        ];
    }

    public function getTableName(): string
    {
        return 'Project';
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
        return $query->with('developer')->FilterByRole(auth()->user());
    }
}
