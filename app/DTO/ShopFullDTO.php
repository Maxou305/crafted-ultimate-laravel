<?php

namespace App\DTO;

use App\Models\Shop;

class ShopFullDTO
{
    public $id;
    public $name;
    public $biography;
    public $theme;
    public $logo;
    public $user;

    public function __construct(Shop $shop)
    {
        $this->id = $shop->id;
        $this->name = $shop->name;
        $this->biography = $shop->biography;
        $this->theme = $shop->theme;
        $this->logo = $shop->logo;
        $this->user = $shop->user;
    }
}
