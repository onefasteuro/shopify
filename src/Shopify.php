<?php

namespace onefasteuro\Shopify;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Http\Request;
use onefasteuro\Shopify\Exceptions\ShopifyThrottleException;

class Shopify implements GraphQLContract
{

	
	protected $client;

	protected $events;

	protected $endpoints;
	
	protected $throttle = null;


    /**
     * Shopify constructor.
     * @param \Requests_Session $client
     * @param DispatcherContract $events
     * @param array $endpoints
     * @param Throttles\ThrottleInterface $throttle
     */
	public function __construct(\Requests_Session $client, DispatcherContract $events, array $endpoints, Throttles\ThrottleInterface $throttle)
	{
	    $this->client = $client;
	    $this->events = $events;
	    $this->endpoints = $this->setupEndpoints($endpoints);
	    $this->throttle = $throttle;

	}

    /**
     * @return \Requests_Session
     */
	public function getClient()
	{
		return $this->client;
	}

    /**
     * @return null|Throttles\ThrottleInterface
     */
	public function getThrottle()
	{
		return $this->throttle;
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
			$response = $this->client->post('graphql.json', [], $send);
			$output = json_decode($response->body, true);
			$throttled = $this->getThrottle()->assertThrottle($output);
			
			$this->getThrottle()->mightThrottle();;
		}
		while ($throttled === true);

		
		
		return $output;
	}
	
	
	
	
	protected function setupEndpoints($eps)
	{
		$return = [];
		foreach($eps as $k => $ep) {
			$return[$k] = new $ep($this);
		}
		return $return;
	}
	
	
    public static function verifyWebhook(Request $request, $secret)
    {
        $hmac = $request->header('x-shopify-hmac-sha256');
        $output =  $request->getContent();

        $calculated = base64_encode(hash_hmac('sha256', $output, $secret, true));

        return hash_equals($hmac, $calculated);
    }
    
    public function __get($k)
    {
    	if(array_key_exists($k, $this->endpoints)) {
    		return $this->endpoints[$k];
	    }
    }
    

}