<?php

namespace onefasteuro\Shopify\Controllers;


use App\Http\Controllers\Controller;
use onefasteuro\Shopify\Shopify;

class BaseController extends Controller
{
	protected $client;
	
	public function __construct(Shopify $client)
	{
		$this->client = $client;
	}
}
