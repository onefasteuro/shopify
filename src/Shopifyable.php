<?php

namespace onefasteuro\Shopify;

use Illuminate\Support\Facades\Log;
use Requests_Session;


trait Shopifyable
{


    public function shopify($app = null)
    {
        return app(Shopify::class);
    }


}