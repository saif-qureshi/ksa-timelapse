<?php

namespace App\Livewire;

use App\Contracts\CrudListContract;
use Livewire\Component;
use App\Models\Comment;
use App\Traits\CrudListHelper;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class CommentList extends Component implements CrudListContract
{
    use WithPagination, CrudListHelper;
    public string $model = Comment::class;
    public $sortField = 'id';
    protected string $paginationTheme = 'tailwind';

    public function buildFilters(): array
    {
        return [];
    }

    public function buildTable(): array
    {
        return [
            [
                'name' => 'User',
                'html'        => true,
                'cb'          => fn ($comment) => $comment->user->full_name
            ],
            [
                'name' => 'Camera',
                'html'   => true,
                'cb'   => function ($comment) {
                    return "
                    {$comment->photo->camera->developer->name}</br>
                    {$comment->photo->camera->project->name}</br>
                    {$comment->photo->camera->name}</br>
                    ";
                }
            ],
            [
                'name' => 'Comment',
                'key' => 'message',
            ],
            [
                'name' => 'Approved',
                'checkActive' => 'is_approved',
                'checkedYesLabel' => "Yes",
                'checkedNoLabel' => "No",
            ],
            [
                'name'    => 'Action',
                'actions' => [
                    [
                        'name'  => 'Approve',
                        'icon'  => 'tick',
                        'route' => function ($comment) {
                            return route('comments.approve', $comment->id);
                        }
                    ],
                    // [
                    //     'name'  => 'Delete',
                    //     'class' => 'deleteBtn text-danger',
                    //     'icon'  => 'dustbin',
                    //     'route' => function ($comment) {
                    //         return route('comments.destroy', $comment->id);
                    //     }
                    // ]
                ]
            ]
        ];
    }

    public function getTableName(): string
    {
        return 'comments';
    }


    public function getWith(): string|array|null
    {
        return ['user', 'photo', 'photo.camera', 'photo.camera.developer', 'photo.camera.project'];
    }

    public function getSearchOptions(): array
    {
        return [
            'enabled'      => true,
            'placeholder'  => 'Search by message',
            'searchFields' => [
                'message',
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
