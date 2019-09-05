<?php

namespace onefasteuro\Shopify\Controllers;

use Illuminate\Http\Request;

class WebhooksController extends BaseController
{

	public function collectionWasCreated(Request $request)
    {
    	return response()->json([], 200);
    }
	
	public function collectionWasDeleted(Request $request)
	{
		$id = $request->get('id');

		return response()->json([], 200);
	}
	
	public function collectionWasUpdated(Request $request)
	{
		//the ID of the collection
		$id = $request->get('id');
		
		return response()->json([], 200);
	}


    /**
     * Fired when a product is created
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
	public function productWasCreated(Request $request)
	{
		$id = $request->get('id');
		
		return response()->json([], 200);
	}

    /**
     * Fires when a product is deleted
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
	public function productWasDeleted(Request $request)
	{
		$id = $request->get('id');
		
		return response()->json([], 200);
	}


    /**
     * Fires when a product is updated
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
	public function productWasUpdated(Request $request)
	{
		//the ID of the collection
		$id = $request->get('id');
		
		return response()->json([], 200);
	}
}
