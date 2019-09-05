<?php

namespace onefasteuro\Shopify\Events;

use onefasteuro\Shopify\Models\Collection;
use onefasteuro\Shopify\Models\Product;

class ProductFromShopifyEvent
{
	public $product;
	public $payload;
	
	public function __construct(Product $p, $payload)
	{
		$this->product = $p;
		$this->payload = $payload;
	}
}