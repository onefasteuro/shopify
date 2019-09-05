<?php
	
	namespace onefasteuro\Shopify\Jobs\Storefront;

use onefasteuro\Shopify\Events\Storefront\StorefrontProduct;
use onefasteuro\Shopify\Helpers;
use onefasteuro\Shopify\Models\Product;
use Carbon\Carbon;
use onefasteuro\Shopify\Jobs\ShopifyJob;

class SaveProduct extends ShopifyJob
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
	
	    //let's see if we have a product available
	    $product = Product::where('id', '=', $id)->first();
	    if(!$product) {
		    $product = new Product;
		    $product->id = $id;
	    }
	
	    $product->storefront_id = $result['id'];
	    $product->title = $result['title'];
	    $product->handle = $result['handle'];
	    $product->type = $result['productType'];
	    $product->max_price = $result['priceRange']['maxVariantPrice']['amount'];
	    $product->min_price = $result['priceRange']['minVariantPrice']['amount'];
	    $product->vendor = $result['vendor'];
	    $product->date_created = new Carbon($result['createdAt']);
	    $product->save();
	
	    $payload = [
		    'variants' => Helpers::prepareVariantsData($result['variants']['edges']),
		    'tags' => Helpers::prepareTagPairs($result['tags']),
		    'collections' => Helpers::prepareCollectionIds($result['collections']['edges'])
	    ];
	
	
	    event(new StorefrontProduct($product, $payload));
    }
    
    
}
