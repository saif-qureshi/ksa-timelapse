<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comment;
use Livewire\WithPagination;

class CommentList extends Component
{
    use WithPagination;
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
                'key' => 'user_id',
               
            ],
            [
                'name' => 'Comment',
                'key' => 'content',
                'sort' => true,
            ],
            [
                'name' => 'Camera',
                'key'   => 'camera_id'
            ],
            [
                'name' => 'Approved',
                'key'   => 'approved'
            ],
            [
                'name'    => 'Action',
                'actions' => [
                    [
                        'name'  => 'Edit',
                        'icon'  => 'tick',
                        'route' => function ($comments) {
                            return route('comments.edit', $comments->id);
                        }
                    ],
                    [
                        'name'  => 'Delete',
                        'class' => 'deleteBtn text-danger',
                        'icon'  => 'dustbin',
                        'route' => function ($comments) {
                            return route('comments.destroy', $comments->id);
                        }
                    ]
                ]
            ]
        ];
    }

    public function getTableName(): string
    {
        return 'Comments';
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
        $comments = Comment::with('camera','user')->paginate(10);
        return view('livewire.pages.comment-list')
            ->with([
                'data'    =>  $comments,
                'table'   => $this->buildTable(),
            ]);
    }
}
