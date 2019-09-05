<?php

namespace onefasteuro\Shopify\Jobs\Storefront;

use onefasteuro\Shopify\Helpers;
use onefasteuro\Shopify\Models\Collection;
use onefasteuro\Shopify\Jobs\ShopifyJob;

class SaveCollection extends ShopifyJob
{
    public $payload;


    public function __construct(array $data)
    {
        $this->payload = $data;
    }

    public function handle()
    {
    	$result =& $this->payload;
	
	    $id = Helpers::getId($result['id'], true);
	
	    $handle = $result['handle'];
	    $title = $result['title'];
	
	    $collection = Collection::where('id', '=', $id)->first();
	    if(!$collection) {
		    $collection = new Collection;
		    $collection->id = $id;
	    }
	
	    $collection->title = $title;
	    $collection->handle = $handle;
	
	    $collection->save();
    }
    
    
}
