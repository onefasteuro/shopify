<?php

namespace onefasteuro\Shopify\Events;

use onefasteuro\Shopify\Models\Collection;
use onefasteuro\Shopify\Models\Product;

class CollectionEvent
{
	public $collection;
	
	public function __construct($p)
	{
		$this->collection = $p;
	}
}