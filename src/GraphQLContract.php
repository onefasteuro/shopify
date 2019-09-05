<?php

namespace onefasteuro\Shopify;



interface GraphQLContract
{
	public function query($gql, $variables = []);

	public function getClient();

}