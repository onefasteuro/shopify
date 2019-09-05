<?php
	
	namespace onefasteuro\Shopify\Jobs\Webhooks;

use onefasteuro\Shopify\Events\Storefront\StorefrontProduct;
use onefasteuro\Shopify\Helpers;
use onefasteuro\Shopify\Models\Product;
use Carbon\Carbon;
use onefasteuro\Shopify\Jobs\ShopifyJob;
use onefasteuro\Shopify\Queries\ProductQuery;
use onefasteuro\Shopify\Storefront;

class SaveProduct extends ShopifyJob
{
    public $payload;


    public function __construct(array $data)
    {
        $this->payload = $data;
    }

    public function handle(Storefront $storefront)
    {
	
	    //let's see if we have a product available
	    $product = Product::where('id', '=', $this->payload['id'])->first();
	    if(!$product) {
		    $product = new Product;
		    $product->id = $this->payload['id'];
	    }
	    
	    $data = $storefront->query(ProductQuery::get('storefrontFindByHandle'), ['n' => $this->payload['handle'] ]);
	
	    $product->storefront_id = $this->payload['id'];
	    $product->title = $this->payload['title'];
	    $product->handle = $this->payload['handle'];
	    $product->type = $this->payload['product_type'];
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
