<?php

namespace onefasteuro\Shopify\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use onefasteuro\Shopify\Models\Collection;
use onefasteuro\Shopify\Models\CollectionsCategory;
use onefasteuro\Shopify\Models\Product;
use onefasteuro\Shopify\Models\ProductTag;
use Illuminate\Support\Str;

class FeedController extends BaseController
{

    public function getVendors()
    {
        $results = Product::groupBy('vendor')->simplePaginate(25, ['vendor']);

        $data["channel"]["item"] = $results->toArray();
        $data["next"] = $results->nextPageUrl();

        return response()->json($data);

    }
	
	public function getCollections()
	{
		$first = DB::table('collections')->select(['title', 'handle', DB::raw("false AS category")]);
		$results = DB::table('product_tags')->select(['tag_value AS title', 'tag_value AS handle', DB::raw("true AS category")])->distinct()->where('tag_name', '=', 'category')->union($first)->paginate(15);
		
		
		$output = [];
		$results->each(function($r) use(&$output) {
			$as_array = json_decode( json_encode($r), true );
			if($as_array['category'] === 1) {
				$as_array['handle'] = Str::slug($as_array['title']);
			}
			$output[] = $as_array;
		});
		
		
		$data["channel"]["item"] = $output;
		$data["next"] = $results->nextPageUrl();
		
		return response()->json($data);
	}
	
	public function getProducts(Request $request)
	{
		$products = Product::simplePaginate(50);
		
		$output = [];
		$data = [];
		
		$products->each(function($p) use(&$output) {
			$as_array = $p->toArray();
			$output[] = $as_array;
		});
		
		$data["channel"]["item"] = $output;
		$data["next"] = $products->nextPageUrl();
		
		return response()->json($data);
	}
}
