<?php

namespace onefasteuro\Shopify\Models;

use \Eloquent;

class ProductTag extends Eloquent
{
	public $timestamps = false;

	protected $table = 'product_tags';


	public function product()
	{
		return $this->belongsTo(Product::class);
	}


    /**
     * Delete the associations to the given product
     * @param Product $product
     */
	public static function deleteProductAssociation(Product $product)
    {
        $tags = static::where('product_id', '=', $product->id)->get();
        if(count($tags) > 0) {
            foreach($tags as $tag) {
                $tag->delete();
            }
        }
    }


	public static function saveProductAssociation(array $data, $product_id)
    {
        //get the current tags attached
        $tags = static::where('product_id', '=', $product_id)->get();

        $saved = [];

        if(count($data) > 0) {
            foreach($data as $v) {
                $exists = static::where('tag_name', '=', $v['tag_name'])->where('tag_value', '=', $v['tag_value'])->where('tag_slug', '=', $v['tag_slug'])->first();
                if(!$exists) {
                    $exists = new static;
                    $exists->product_id = $product_id;
                    $exists->tag_name = $v['tag_name'];
                    $exists->tag_value = $v['tag_value'];
                    $exists->facet = $v['facet'];
                    $exists->tag_slug = $v['tag_slug'];
                    $exists->save();
                }

                $saved[] = $exists;
            }
        }


        //TODO: clean up unsued tags
        static::orphansCleanup($tags, $saved);

        return $saved;
    }



    public static function orphansCleanup($current, $saved)
    {

    }

}