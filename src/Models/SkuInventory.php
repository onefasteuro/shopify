<?php

namespace onefasteuro\Shopify\Models;

use Eloquent;
use onefasteuro\Shopify\Helpers;

class SkuInventory extends Eloquent
{
	protected $table = 'sku_inventory';


    public function setVariantIdAttribute($value) {
        $this->attributes['variant_id'] = Helpers::getId($value);
    }

    public function setShopifyIdAttribute($value)
    {
        $this->attributes['shopify_id'] = Helpers::getId($value);
    }

    public function getShopifyIdAttribute($value)
    {
        return Helpers::getShopifyId($value, 'ProductVariant');
    }


    public static function saveProductAssociation(array $sku, $product_id)
    {
    	$id = Helpers::getId($sku['id']);
    	
    	$exists = static::where('variant_id', '=', $id)->where('product_id', '=', $product_id)->first();
    	if(!$exists) {
    		$exists = new static;
    		$exists->variant_id = $sku['id'];
    		$exists->product_id = $product_id;
	    }
	    
	    
	    $exists->inventory_policy = $sku['inventoryPolicy'];
    	$exists->inventory = $sku['inventoryQuantity'];
    	$exists->save();


        //TODO: remove unused variants
    }

    public static function orphansCleanup($current, $saved)
    {

    }

}