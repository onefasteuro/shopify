<?php
	
namespace onefasteuro\Shopify\Jobs\ShopifyAdmin;

use Illuminate\Support\Facades\Log;
use onefasteuro\Shopify\Jobs\ShopifyJob;
use onefasteuro\Shopify\Queries\ProductQuery;
use onefasteuro\Shopify\Shopify;
use onefasteuro\Shopify\Models\SkuInventory;

class AssertSkuInventory extends ShopifyJob
{
	public $product_id;

    public function __construct($product)
    {
    	$this->product_id = $product;
    }

    public function handle(Shopify $shopify)
    {
        $results = $shopify->query(ProductQuery::adminVariantQuery(), ['query_data' => 'product_id:' . $this->product_id]);
        
        
        $data = [];
        if(array_key_exists('data', $results)) {
	        $data = $results['data']['productVariants']['edges'];
        }
        
        
        if(count($data) > 0) {
        	$this->saveData($data);
        }
    }
    
    protected function saveData(array $skus)
    {
    	$saved = [];
    	
    	
    	
        foreach($skus as $sku) {
        	//data is in the "node" key
        	$s = $sku['node'];
	        $saved[] = SkuInventory::saveProductAssociation($s, $this->product_id);
        }
        
        Log::info(json_encode($saved));
    }
}
