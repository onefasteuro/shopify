<?php

namespace onefasteuro\Shopify\Endpoints;



use onefasteuro\Shopify\Fragments\CollectionFragment;

class Collections extends BaseEndpoint
{
	public function all($next = null, $limit = 10)
	{
		
		$call = 'query($l: Int, $n: String) {
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
' . CollectionFragment::fragment() . '
';
		
		return $this->client->query($call, ["l" => $limit, "n" => $next]);
	}
	
	
	public function find($id)
	{
		$id = \onefasteuro\Shopify\Helpers::getShopifyId($id, 'Collection');
		
		$call = '{
	    collection(id: "'. $id . '") {
	        ...collectionFragment
	}
}' . CollectionFragment::fragment();
		
		return $this->client->query($call);
	}
	
}