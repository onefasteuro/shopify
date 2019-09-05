<?php

namespace onefasteuro\Shopify\Queries;

use onefasteuro\Shopify\Fragments\ProductFragment;


class ProductQuery extends BaseQuery
{

    public static function storefrontQuery() {
        $call = 'query($l: Int, $n: String) {
	    products(first: $l, after: $n) {
	       pageInfo {
	        hasNextPage
	       }
	       edges {
	        cursor
	        node {
	            ...productFragment
	        }
	    }
	}
} ' . ProductFragment::storefrontFragment();
        return $call;
    }

    
    public static function adminVariantQuery()
    {
	    $call = 'query($query_data: String) {
	    productVariants(first: 150, query: $query_data) {
	       edges {
	        node {
		        id
		        inventoryQuantity
		        inventoryPolicy
	        }
	    }
	}
}';
	    return $call;
    }
}