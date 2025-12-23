<?php

namespace App\Events\Voyager;

use App\Models\Menu;
use Illuminate\Queue\SerializesModels;

class MenuDisplay
{
    use SerializesModels;

    public $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;

        // @deprecate
        //
        event('voyager.menu.display', $menu);
    }
}
