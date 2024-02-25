<?php

namespace App\Livewire;

use App\Contracts\CrudListContract;
use App\Models\User;
use App\Traits\CrudListHelper;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class UserList extends Component implements CrudListContract
{
    use WithPagination, CrudListHelper;

    public string $model = User::class;
    public $sortField = 'id';
    public ?string $createUrl = "user.create";
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
                'sort' => true,
                'cb' => fn ($user) => $user->full_name
            ],
            [
                'name' => 'Email',
                'key'   => 'email'
            ],
            [
                'name' => 'Role',
                'html' => true,
                'cb' => fn ($user) => Str::of($user->role)->replace('_', ' ')->ucfirst()->value
            ],
            [
                'name'        => 'Last login',
                'sort'        => true,
                'html'        => true,
                'cb'          => fn ($user) => $user->last_login_at?->format('M d, Y, g:i A') ?? '--'
            ],
            [
                'name'        => 'Created At',
                'html'        => true,
                'sort'        => true,
                'cb'          => fn ($user) => $user->created_at->format('M d, Y, g:i A')
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
                        'route' => function ($user) {
                            return route('user.edit', $user->id);
                        }
                    ],
                    [
                        'name'  => 'Delete',
                        'class' => 'deleteBtn text-danger',
                        'icon'  => 'dustbin',
                        'route' => function ($user) {
                            return route('user.destroy', $user->id);
                        }
                    ]
                ]
            ]
        ];
    }

    public function getTableName(): string
    {
        return 'Users';
    }


    public function getWith(): ?string
    {
        return "";
    }

    public function getSearchOptions(): array
    {
        return [
            'enabled'      => true,
            'placeholder'  => 'Search by Name or email',
            'searchFields' => [
                'first_name',
                'last_name',
                'email',
                'role'
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
}
