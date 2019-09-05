<?php

namespace onefasteuro\Shopify;



class Storefront implements GraphQLContract
{
	protected $client;

	public function __construct(\Requests_Session $client)
	{
	    $this->client = $client;
	}

	public function getClient()
	{
		return $this->client;
	}
	
	
	public function query($gql, $variables = [])
	{
        $retry = true;

        if(count($variables) > 0) {
            $send = ["query" => $gql, "variables" => $variables];
        }
        else {
            $send = ["query" => $gql];
        }

        $send = json_encode($send);

        do {
            try {
                $response = $this->client->post('', [], $send);
                $retry = false;
            }
            catch(\Requests_Exception $e) {
                \Log::error($e->getMessage());
                if($e->getType() == 'curlerror') {
                    $retry = true;
                }
            }
        }
        while ($retry === true);

        $output = json_decode($response->body, true);



        $output = static::checkOutput($output);
		
		return static::checkOutput($output);
	}
	
	public static function checkOutput($data)
	{
		if(array_key_exists('errors', $data)) {
		
		}
		
		return $data;
	}

}