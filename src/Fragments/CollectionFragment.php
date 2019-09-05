<?php

namespace onefasteuro\Shopify\Fragments;



class CollectionFragment implements FragmentContract
{

    public static function fragment() {
        return 'fragment collectionFragment on Collection {
        id
	    handle
	    title      
    }';
    }

}