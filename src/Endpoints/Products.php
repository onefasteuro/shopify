<?php

namespace onefasteuro\Shopify\Endpoints;



use onefasteuro\Shopify\Fragments\ProductFragment;

class Products extends BaseEndpoint
{
	public function all($next = null, $limit = 7)
	{
		
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
} ' . ProductFragment::fragment();

		return $this->client->query($call, ["l" => $limit, "n" => $next]);
	}
	
	public function find($id)
	{
		$id = \onefasteuro\Shopify\Helpers::getShopifyId($id, 'Product');
		
		$call = '{
	     product(id: "'. $id . '") {
	        ...productFragment
		}
	}' . ProductFragment::fragment();

		return $this->client->query($call);
	}
}