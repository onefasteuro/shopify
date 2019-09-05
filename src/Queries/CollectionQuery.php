<?php

namespace onefasteuro\Shopify\Queries;

use onefasteuro\Shopify\Fragments\CollectionFragment;


class CollectionQuery extends BaseQuery
{

    public static function storefrontQuery() {
       return 'query($l: Int, $n: String) {
	    collections(first: $l, after: $n) {
	       pageInfo {
	        hasNextPage
	       }
	       edges {
	        cursor
	        node {
	            ...collectionFragment   
	        }
	    }
	}
}
' . CollectionFragment::fragment();
    }

}