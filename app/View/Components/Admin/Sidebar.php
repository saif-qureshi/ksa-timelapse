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
                'visible'    => true,
                'child'     => [],
            ],
            [
                'name'      => 'Home',
                'icon'      => 'tv-2',
                'link'      => route('home.developers'),
                'condition' => 'home',
                'visible'    => true,
                'child'     => [],
            ],
            [
                'name'      => 'Downloads',
                'icon'      => 'download',
                'link'      => route('download'),
                'condition' => 'download',
                'visible'    => true,
                'child'     => [],
            ],
            [
                'name'      => 'Users',
                'icon'      => 'users',
                'link'      => route('user.index'),
                'condition' => 'dashboard',
                'visible'    => in_array(auth()->user()->role, ['admin', 'super_admin']),
                'child'     => [],
            ],
            [
                'name'      => 'Developers',
                'icon'      => 'hard-hat',
                'link'      => route('developer.index'),
                'condition' => 'dashboard',
                'visible'    => in_array(auth()->user()->role, ['admin', 'super_admin', 'project_admin']),
                'child'     => [],
            ],
            [
                'name'      => 'Projects',
                'icon'      => 'building-2',
                'link'      => route('project.index'),
                'visible'    => in_array(auth()->user()->role, ['admin', 'super_admin', 'project_admin']),
                'condition' => 'dashboard',
                'child'     => [],
            ],
            [
                'name'      => 'Cameras',
                'icon'      => 'cctv',
                'link'      => route('camera.index'),
                'condition' => 'dashboard',
                'visible'    => in_array(auth()->user()->role, ['admin', 'super_admin', 'project_admin']),
                'child'     => [],
            ],
            [
                'name'      => 'Comments',
                'icon'      => 'message-square-text',
                'link'      => route('comments.index'),
                'condition' => 'dashboard',
                'visible'    => in_array(auth()->user()->role, ['admin', 'super_admin','project_admin']),
                'child'     => [],
            ],
            [
                'name'      => 'Settings',
                'icon'      => 'settings',
                'link'      => route('settings.index'),
                'condition' => 'dashboard',
                'visible' => auth()->user()->role === 'super_admin',
                'child'     => [],
            ],
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
