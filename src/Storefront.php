<?php

namespace onefasteuro\Shopify;



use onefasteuro\Shopify\Throttles\StorefrontThrottle;

class Storefront implements GraphQLContract
{
	protected $client;
	protected $throttle;

	public function __construct(\Requests_Session $client, StorefrontThrottle $t)
	{
		$this->throttle = $t;
	    $this->client = $client;
	}

	public function getClient()
	{
		return $this->client;
	}
	
	
	public function query($gql, $variables = [])
	{

        if(count($variables) > 0) {
            $send = ["query" => $gql, "variables" => $variables];
        }
        else {
            $send = ["query" => $gql];
        }

        $send = json_encode($send);
		
		$output = null;
		$throttled = true;

        do {
	
	        $response = $this->client->post('', [], $send);
	        $output = json_decode($response->body, true);
	        $throttled = $this->getThrottle()->assertThrottle($output);
	
	        $this->getThrottle()->mightThrottle();
        }
        while ($throttled === true);
		
		return $output;
	}

}