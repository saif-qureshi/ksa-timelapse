<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use App\View\Components\Admin\Sidebar;


class MobileMenu extends Sidebar
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the view / contents that represent the component.
     * @return View|string
     */
    public function render()
    {
        $this->convertMenuArrayIntoCollection();

        return view('components.admin.mobile-menu');
    }
}
