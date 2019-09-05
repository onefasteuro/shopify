<?php

namespace onefasteuro\Shopify;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

//events
use onefasteuro\Shopify\Events\CollectionWasDeleted;
use \onefasteuro\Shopify\Events\ProductWasDeleted;

use onefasteuro\Shopify\Models\CollectionProduct;
use onefasteuro\Shopify\Models\ProductTag;

use onefasteuro\Shopify\Events\Storefront\StorefrontProduct;


//jobs
use onefasteuro\Shopify\Jobs\ShopifyAdmin\AssertSkuInventory;

class ShopifyEventsServiceProvider extends ServiceProvider
{
	
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->collectionEvents();
        $this->productEvents();
    }


    protected function collectionEvents()
    {
        Event::listen(CollectionWasDeleted::class, function(CollectionWasDeleted $event){
            CollectionProduct::deleteCollectionAssociation($event->collection);
        });
    }



    protected function productEvents()
    {
    	//product deleted, let's cleanup the nodes
        Event::listen(ProductWasDeleted::class, function($event) {
	        ProductTag::deleteProductAssociation($this->product);
	        CollectionProduct::deleteProductAssociation($this->product);
        });
        

        //product created, save the tags and grab the inventory
        Event::listen(StorefrontProduct::class, function(StorefrontProduct $event) {
        	$product = $event->product;
        	
	        $saved_tags = ProductTag::saveProductAssociation($event->payload['tags'], $product->id);
	        $saved_cp = CollectionProduct::saveProductAssociation($event->payload['collections'], $product->id);
            
            dispatch( new AssertSkuInventory($product->id) );
            
        });
    }

}
