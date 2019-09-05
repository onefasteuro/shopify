<?php

namespace onefasteuro\Shopify\Models;

use \Eloquent;

class CollectionProduct extends Eloquent
{
	protected $table = 'collection_product';


    /**
     * Save the association of products to collections
     * @param array $result
     * @param Product $product
     */
	public static function saveProductAssociation(array $collections, $product_id)
    {
        //get the current associations
        $current = static::where('product_id', '=', $product_id)->get();

        $saved = [];
        if(count($collections) > 0) {
            foreach($collections as $id) {
                $exists = static::where('collection_id', '=', $id)->where('product_id', '=', $product_id)->first();
                if(!$exists) {
                    $exists = new static;
                    $exists->product_id = $product_id;
                    $exists->collection_id = $id;
                    $exists->save();
                }
                $saved[] = $exists;
            }
        }


        //TODO: delete any associations not needed
        static::orphansCleanup($current, $saved);

        return $saved;
    }


    /**
     * Delete the associations to the given product
     * @param Product $product
     */
    public static function deleteProductAssociation(Product $product)
    {
        $c = static::where('product_id', '=', $product->id)->get();
        if(count($c) > 0) {
            foreach($c as $assoc) {
                $assoc->delete();
            }
        }
    }


    /**
     * Deletes the association to the given collection
     * @param Collection $collection
     */
    public static function deleteCollectionAssociation(Collection $collection)
    {
        $c = static::where('collection_id', '=', $collection->id)->get();
        if(count($c) > 0) {
            foreach($c as $assoc) {
                $assoc->delete();
            }
        }
    }



    public static function orphansCleanup($current, $saved)
    {

    }
}