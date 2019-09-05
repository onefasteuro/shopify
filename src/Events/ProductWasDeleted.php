<?php

namespace onefasteuro\Shopify\Events;


class ProductWasDeleted
{
    public $product_id;

    public function __construct($p)
    {
        $this->product_id = $p;
    }
}