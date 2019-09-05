<?php

namespace onefasteuro\Shopify\Models;

use \Eloquent;
use Illuminate\Support\Facades\Event;
use onefasteuro\Shopify\Events\ProductFromShopifyEvent;
use onefasteuro\Shopify\Events\ProductWasCreated;
use onefasteuro\Shopify\Events\ProductWasDeleted;
use onefasteuro\Shopify\Events\ProductWasSaved;
use onefasteuro\Shopify\Helpers;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class Product extends Eloquent
{
    use Notifiable;

	protected $table = 'products';

    public $incrementing = false;


    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => ProductWasSaved::class,
        'deleted' => ProductWasDeleted::class,
    ];


	public function collections()
	{
		return $this->belongsToMany(Collection::class, 'collection_product', 'product_id', 'collection_id');
	}
	
	public function productTags()
	{
		return $this->hasMany(ProductTag::class, 'product_id');
	}
	
	public function setIdAttribute($value) {
		$this->attributes['id'] = Helpers::getId($value);
	}
	
	
	public function getShopifyIdAttribute()
	{
		return Helpers::getShopifyId($this->id, 'Product');
	}
	
	
}