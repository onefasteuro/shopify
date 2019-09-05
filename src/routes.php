<?php



Route::post('api/shopify/webhooks/collections/create', ['as' => 'shopify.webhooks.collection.create',
	'uses' => 'onefasteuro\Shopify\Controllers\WebhooksController@collectionWasCreated']);
Route::post('api/shopify/webhooks/collections/update', ['as' => 'shopify.webhooks.collection.update',
	'uses' => 'onefasteuro\Shopify\Controllers\WebhooksController@collectionWasUpdated']);
Route::post('api/shopify/webhooks/collections/delete', ['as' => 'shopify.webhooks.collection.delete',
	'uses' => 'onefasteuro\Shopify\Controllers\WebhooksController@collectionWasDeleted']);
	
	
	
Route::post('api/shopify/webhooks/products/create', ['as' => 'shopify.webhooks.product.create',
		'uses' => 'onefasteuro\Shopify\Controllers\WebhooksController@productWasCreated']);
Route::post('api/shopify/webhooks/products/update', ['as' => 'shopify.webhooks.product.update',
		'uses' => 'onefasteuro\Shopify\Controllers\WebhooksController@productWasUpdated']);
Route::post('api/shopify/webhooks/products/delete', ['as' => 'shopify.webhooks.product.delete',
		'uses' => 'onefasteuro\Shopify\Controllers\WebhooksController@productWasDeleted']);

	
Route::get('api/shopify/feed/collections', ['as' => 'shopify.feed.get.collections',
		'uses' => 'onefasteuro\Shopify\Controllers\FeedController@getCollections']);
Route::get('api/shopify/feed/vendors', ['as' => 'shopify.feed.get.vendors',
    'uses' => 'onefasteuro\Shopify\Controllers\FeedController@getVendors']);

	
Route::get('api/shopify/feed/products', ['as' => 'shopify.feed.get.products',
		'uses' => 'onefasteuro\Shopify\Controllers\FeedController@getProducts']);