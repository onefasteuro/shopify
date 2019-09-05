<?php

return [
	
	'type' => 'private', /* private or public */
	'api_key' => env('SHOPIFY_API_KEY', null), /* needed for private app */
	'api_secret' => env('SHOPIFY_API_SECRET', null), /* needed for private app */
	'shop' => env('SHOPIFY_API_SHOP', null),
	'access_token' => env('SHOPIFY_API_ACCESS_TOKEN', null), /* needed for public app */
	'storefront_token' => env('SHOPIFY_STOREFRONT_TOKEN', null), /* needed for public app */

    'endpoints' => [
        'products' => \onefasteuro\Shopify\Endpoints\Products::class,
        'collections' => \onefasteuro\Shopify\Endpoints\Collections::class,
	    'webhooks' => \onefasteuro\Shopify\Endpoints\Webhooks::class
    ],
];