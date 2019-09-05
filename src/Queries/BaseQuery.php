<?php

namespace onefasteuro\Shopify\Queries;


class BaseQuery
{

    public static function get($query) {
        return static::$query();
    }

}