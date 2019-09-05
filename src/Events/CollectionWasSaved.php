<?php

namespace onefasteuro\Shopify\Events;

use onefasteuro\Shopify\Models\Collection;

class CollectionWasSaved
{

    public $collection;

    public function __construct(Collection $c)
    {
        $this->collection = $c;
    }
}