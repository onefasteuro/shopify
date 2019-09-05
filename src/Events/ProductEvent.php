<?php

namespace onefasteuro\Shopify\Events;

use onefasteuro\Shopify\Models\Collection;
use onefasteuro\Shopify\Models\Product;

class ProductEvent
{
	public $product;
	
	public function __construct($p)
	{
		$this->product = $p;
	}
}