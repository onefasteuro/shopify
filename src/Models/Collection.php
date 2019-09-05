<?php

namespace onefasteuro\Shopify\Models;

use Eloquent;
use onefasteuro\Shopify\Events\CollectionWasDeleted;
use onefasteuro\Shopify\Events\CollectionWasSaved;
use onefasteuro\Shopify\Helpers;
use Illuminate\Notifications\Notifiable;


class Collection extends Eloquent
{
    use Notifiable;

	protected $table = 'collections';

    public $incrementing = false;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => CollectionWasSaved::class,
        'deleted' => CollectionWasDeleted::class,
    ];

	public function products()
	{
		return $this->belongsToMany(Product::class, 'collection_product', 'collection_id', 'product_id');
	}
	
	
	public function setIdAttribute($value)
	{
		$this->attributes['id'] = Helpers::getId($value);
	}
	
	public function getShopifyIdAttribute()
	{
		return Helpers::getShopifyId($this->id, 'Collection');
	}
}