<?php

namespace onefasteuro\Shopify\Schema;



class NodeList
{
	private $nodes = [];
	
	public function add(Node $node)
	{
		$this->nodes[] = $node;
		
	}
}