<?php

namespace onefasteuro\Shopify\Endpoints;

use onefasteuro\Shopify\Shopify;

abstract class BaseEndpoint implements EndpointInterface
{
    protected $client;

    public function __construct(Shopify $client)
    {
        $this->client = $client;
    }


}