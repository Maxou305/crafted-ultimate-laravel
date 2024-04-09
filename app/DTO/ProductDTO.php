<?php

namespace App\DTO;

use App\Models\Product;

class ProductDTO
{
    public $id;
    public $name;
    public $price;
    public $description;
    public $story;
    public $image;
    public $category;
    public $material;
    public $color;
    public $size;
    public $stock;
    public $shop;

    public function __construct(Product $product)
    {
        $this->id = $product->id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->description = $product->description;
        $this->story = $product->story;
        $this->image = $product->image;
        $this->category = $product->category;
        $this->material = $product->material;
        $this->color = $product->color;
        $this->size = $product->size;
        $this->stock = $product->stock;
        $this->shop = new ShopFullDTO($product->shop);
    }
}
