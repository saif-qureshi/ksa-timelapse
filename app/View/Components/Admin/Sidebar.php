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
                'name'      => 'Downloads',
                'icon'      => 'download',
                'link'      => '#',
                'condition' => 'dashboard',
                'child'     => [],
            ],
            [
                'name'      => 'Users',
                'icon'      => 'users',
                'link'      => '#',
                'condition' => 'dashboard',
                'child'     => [
                    [
                        'name'      => 'Developer',
                        'icon'      => 'user',
                        'link'      => '#',
                        'condition' => 'dashboard',
                        'child'     => []
                    ],
                    [
                        'name'      => 'users',
                        'icon'      => 'user',
                        'link'      => '#',
                        'condition' => 'dashboard',
                        'child'     => []
                    ],
                ],
            ],
            [
                'name'      => 'Projects',
                'icon'      => 'building-2',
                'link'      => '#',
                'condition' => 'dashboard',
                'child'     => [],
            ],
            [
                'name'      => 'Cameras',
                'icon'      => 'cctv',
                'link'      => '#',
                'condition' => 'dashboard',
                'child'     => [],
            ],
            // [
            //     'name'      => 'Artist Management',
            //     'icon'      => 'users',
            //     'link'      => 'javascript:void(0)',
            //     'condition' => 'dashboard',
            //     'child'     => [
            //         [
            //             'name'      => 'Artists',
            //             'icon'      => 'user',
            //             'link'      => '#',
            //             'condition' => 'dashboard',
            //             'child'     => []
            //         ],
            //         [
            //             'name'      => 'Bookings',
            //             'icon'      => 'calendar',
            //             'link'      => route('admin.booking.index'),
            //             'condition' => 'dashboard',
            //             'child'     => [],
            //         ]
            //     ],
            // ],
            // [
            //     'name'      => 'Labels',
            //     'icon'      => 'mic',
            //     'link'      => route('admin.label.index'),
            //     'condition' => 'dashboard',
            //     'child'     => [],
            // ],
            // [
            //     'name'      => 'Releases',
            //     'icon'      => 'bell',
            //     'link'      => route('admin.release.index'),
            //     'condition' => 'dashboard',
            //     'child'     => [],
            // ],
            // [
            //     'name'      => 'Playlists',
            //     'icon'      => 'music',
            //     'link'      => route('admin.playlist.index'),
            //     'condition' => 'dashboard',
            //     'child'     => [],
            // ],
            // [
            //     'name'      => 'Album',
            //     'icon'      => 'film',
            //     'link'      => route('admin.album.index'),
            //     'condition' => 'dashboard',
            //     'child'     => [],
            // ],
            // [
            //     'name'      => 'Podcasts',
            //     'icon'      => 'film',
            //     'link'      => route('admin.podcast.index'),
            //     'condition' => 'dashboard',
            //     'child'     => [],
            // ],
            // [
            //     'name'      => 'Songs',
            //     'icon'      => 'headphones',
            //     'link'      => route('admin.song.index'),
            //     'condition' => 'dashboard',
            //     'child'     => [],
            // ],
            // [
            //     'name'      => 'Videos',
            //     'icon'      => 'youtube',
            //     'link'      => route('admin.video.index'),
            //     'condition' => 'dashboard',
            //     'child'     => [],
            // ],
            // [
            //     'name'      => 'Events',
            //     'icon'      => 'calendar',
            //     'link'      => route('admin.event.index'),
            //     'condition' => 'dashboard',
            //     'child'     => [],
            // ],
            // [
            //     'name'      => 'News',
            //     'icon'      => 'book-open',
            //     'link'      => route('admin.news.index'),
            //     'condition' => 'dashboard',
            //     'child'     => [],
            // ],
            // [
            //     'name'      => 'Pages',
            //     'icon'      => 'globe',
            //     'link'      => route('admin.page.index'),
            //     'condition' => 'dashboard',
            //     'child'     => [],
            // ],
            // [
            //     'name'      => 'Contact Forms',
            //     'icon'      => 'mail',
            //     'link'      => route('admin.contact-form.index'),
            //     'condition' => 'dashboard',
            //     'child'     => [],
            // ],
            // [
            //     'name'      => 'Subscribers',
            //     'icon'      => 'user-plus',
            //     'link'      => route('admin.subscriber.index'),
            //     'condition' => 'dashboard',
            //     'child'     => [],
            // ],
            // [
            //     'name'      => 'Configurations',
            //     'icon'      => 'settings',
            //     'link'      => route('admin.settings.index'),
            //     'condition' => 'dashboard',
            //     'child'     => [],
            // ],
            // [
            //     'name'      => 'Home Appearance',
            //     'icon'      => 'settings',
            //     'link'      => route('admin.home-settings.index'),
            //     'condition' => 'dashboard',
            //     'child'     => [],
            // ],
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
