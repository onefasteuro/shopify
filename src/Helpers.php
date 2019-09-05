<?php

namespace onefasteuro\Shopify;

use Carbon\Carbon;
use onefasteuro\Shopify\Models\Collection;
use onefasteuro\Shopify\Models\Product;
use onefasteuro\Shopify\Models\CollectionProduct;
use onefasteuro\Shopify\Models\ProductTag;
use onefasteuro\Shopify\Models\SkuInventory;
use onefasteuro\Shopify\Models\CollectionsCategory;
use Illuminate\Support\Str;

class Helpers
{
	
	public static function getShopifyId($id, $type)
	{
		if (!preg_match('/gid/', $id)) {
			$id = 'gid://shopify/' . ucfirst($type) . '/' . $id;
		}
		
		return $id;
	}

	public static function prepareVariantsData(array $data)
    {
        $output = [];
        foreach($data as $k => $v) {
            $output[] = array(
            	'id' => static::getId($v['node']['id'], true),
	            'sku' => $v['node']['sku']
            );
        }

        return $output;
    }


    /**
     * Prepare the tag pairs
     * @param array $data
     * @return array
     */
	public static function prepareTagPairs(array $data) :array
    {
        if(count($data) === 0) return [];

        $incoming_tags = [];

        foreach($data as $tag) {
            if(strpos($tag, ':')) {
                $split_tag = explode(':', $tag);
                $tag_name = $split_tag[0];
                $tag_value = $split_tag[1];
                $tag_slug = Str::slug($split_tag[1]);
                $facet = (strtolower($tag_name) === 'category') ? true : false;

                $incoming_tags[] = [
                    'tag_name' => $tag_name,
                    'tag_value' => $tag_value,
                    'tag_slug' => $tag_slug,
                    'facet' => $facet
                ];
            }
        }

        return $incoming_tags;
    }



    public static function prepareCollectionIds(array $data)
    {
        if(count($data) === 0) return [];

        $ids = [];
        foreach($data as $k => $v) {
            $id = static::getId($v['node']['id'], true);
            $ids[] = $id;
        }
        return $ids;
    }


    /**
     * @param $id
     * @param bool $storefront
     * @return int
     */
	public static function getId($id, $storefront = false) :int
	{
	    if($storefront === true) {
            $id = base64_decode($id);
        }

		return intval(preg_replace('/[^0-9]/', '', $id));
	}
	
	
	public static function deleteProduct($id)
	{
		$id = static::getId($id);
		
		//first we delete the product
		$p = Product::find($id);
		if ($p) {
			
			//delete all variants
			$variants = SkuInventory::where('product_id', '=', $id)->get();
			
			if (count($variants) > 0) {
				$variants->each(function ($v) {
					$v->delete();
				});
			}
			
			//delete all related collections
			$collection_product = CollectionProduct::where('product_id', '=', $id)->get();
			
			if (count($collection_product) > 0) {
				$collection_product->each(function ($c) {
					$c->delete();
				});
			}
			
			//delete product
			$p->delete();
			
		}
	}


    /**
     * Delete a collection by ID
     * @param $id
     */
	public static function deleteCollection($id)
	{
		$id = static::getId($id);
		$c = Collection::destroy($id);
		CollectionProduct::where('collection_id', '=', $id)->delete();
	}



	public static function saveVariantsProduct($product_id, $variants)
    {
        foreach($variants['edges'] as $variant) {
            $vid = static::getId($variant['node']['id']);
            $v = SkuInventory::where('variant_id', '=', $vid)->where('product_id', '=', $product_id)->first();

            if(!$v) {
                $v = new SkuInventory;
                $v->variant_id = $variant['node']['id'];
                $v->product_id = $product_id;
            }


            $v->inventory = $variant['node']['inventoryQuantity'];
            $v->inventory_policy = $variant['node']['inventoryPolicy'];
            $v->save();
        }
    }

}