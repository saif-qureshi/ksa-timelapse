<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public $menu = [];

    public function __construct()
    {
        $this->menu = collect([
            [
                'name'      => 'Dashboard',
                'icon'      => 'home',
                'link'      => route('dashboard'),
                'condition' => 'dashboard',
                'child'     => [],
            ],
            [
                'name'      => 'Home',
                'icon'      => 'tv-2',
                'link'      => route('home.developers'),
                'condition' => 'home',
                'child'     => [],
            ],
            [
                'name'      => 'Downloads',
                'icon'      => 'download',
                'link'      => '#',
                'condition' => 'dashboard',
                'child'     => [],
            ],
            [
                'name'      => 'Users',
                'icon'      => 'users',
                'link'      => route('user.index'),
                'condition' => 'dashboard',
                'child'     => [],
            ],
            [
                'name'      => 'Developers',
                'icon'      => 'hard-hat',
                'link'      => route('developer.index'),
                'condition' => 'dashboard',
                'child'     => [],
            ],
            [
                'name'      => 'Projects',
                'icon'      => 'building-2',
                'link'      => route('project.index'),
                'condition' => 'dashboard',
                'child'     => [],
            ],
            [
                'name'      => 'Cameras',
                'icon'      => 'cctv',
                'link'      => route('camera.index'),
                'condition' => 'dashboard',
                'child'     => [],
            ],
            [
                'name'      => 'Comments',
                'icon'      => 'message-square-text',
                'link'      => '#',
                'condition' => 'dashboard',
                'child'     => [],
            ]
        ])->filter();
    }

    /**
     * Get the view / contents that represent the component.
     * @return View|string
     */
    public function render()
    {
        $this->convertMenuArrayIntoCollection();

        return view('components.admin.sidebar');
    }

    protected function convertMenuArrayIntoCollection(): void
    {
        $this->menu = $this->menu->map(function ($item) {
            return collect($item)->map(function ($value) {
                return (is_array($value)) ? collect($value)->map(function ($value) {
                    return collect($value)->map(function ($value) {
                        return (is_array($value)) ? collect($value)->map(function ($value) {
                            return collect($value);
                        }) : $value;
                    });
                }) : $value;
            });
        });
    }
}
