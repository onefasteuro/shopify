<?php

namespace onefasteuro\Shopify\Fragments;



class ProductFragment implements FragmentContract
{

    public static function storefrontFragment()
    {
        return 'fragment productFragment on Product {
            id
            createdAt
	        handle
	        title
	        tags
	        productType
	        vendor
	        priceRange {
	            maxVariantPrice {
	                amount
	                currencyCode
	            }
	            minVariantPrice {
	                amount
	                currencyCode
	            }
	        }
	        variants(first: 100) {
	            edges {
	                node {
	                    id
	                    sku
	                }
	            }
	        }
	        collections(first: 20) {
	            edges {
	                node {
	                    id
	                }
	            }
	        }
        }';
    }


    public static function fragment() {
        return 'fragment productFragment on Product {
            id
            createdAt
	        handle
	        title
	        tags
	        productType
	        vendor
	        priceRange {
	            maxVariantPrice {
	                amount
	                currencyCode
	            }
	            minVariantPrice {
	                amount
	                currencyCode
	            }
	        }
	        variants(first: 100) {
	            edges {
	                node {
	                    id
	                    inventoryQuantity
	                    inventoryPolicy
	                }
	            }
	        }
	        collections(first: 20) {
	            edges {
	                node {
	                    id
	                }
	            }
	        }
        }';
    }

}