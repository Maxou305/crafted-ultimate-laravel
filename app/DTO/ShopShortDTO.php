<?php

namespace App\DTO;

use App\Models\Shop;

class ShopShortDTO
{
    public $id;
    public $name;
    public $biography;
    public $theme;
    public $logo;

    public function __construct(Shop $shop)
    {
        $this->id = $shop->id;
        $this->name = $shop->name;
        $this->biography = $shop->biography;
        $this->theme = $shop->theme;
        $this->logo = $shop->logo;
    }
}
