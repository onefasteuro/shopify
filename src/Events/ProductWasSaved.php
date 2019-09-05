<?php

namespace onefasteuro\Shopify\Events;


use onefasteuro\Shopify\Models\Product;

class ProductWasSaved
{
    public $product;

    public function __construct(Product $p)
    {
        $this->product = $p;
    }
}