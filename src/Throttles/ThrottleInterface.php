<?php

namespace onefasteuro\Shopify\Throttles;



interface ThrottleInterface
{
    public function shouldThrottle();

    public function throttle();
    
    public function assertThrottle(array $output);
}