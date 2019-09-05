<?php

namespace onefasteuro\Shopify\Events\Storefront;


use onefasteuro\Shopify\Models\Product;

class StorefrontProduct
{
	public $product;
	public $payload;
	
	public function __construct(Product $p, $payload)
	{
		$this->product = $p;
		$this->payload = $payload;
	}
}