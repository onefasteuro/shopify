<?php
	
	namespace onefasteuro\Shopify\Commands;


use App\Helpers\Slackable;
use App\Models\ShopifyProduct;
use Illuminate\Console\Command;
use App\Jobs\Shopify\GenerateReviewJson;
use App\Jobs\Shopify\SaveProduct;
use onefasteuro\Shopify\Models\CollectionProduct;
use onefasteuro\Shopify\Models\Product;
use onefasteuro\Shopify\Shopify;
use onefasteuro\Shopify\Shopifyable;

class SyncWhitelistCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shopify:whitelist';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Metafields whitelist';

    private $shopify;
    
    
    private $fields = array(
    	[
		    "namespace" => "global",
		    "key" => "description_tag",
		    "ownerType" => "PRODUCT",
	    ],
	    [
		    "namespace" => "global",
		    "key" => "title_tag",
		    "ownerType" => "PRODUCT",
	    ],
	    [
		    "namespace" => "global",
		    "key" => "description_tag",
		    "ownerType" => "COLLECTION",
	    ],
	    [
		    "namespace" => "global",
		    "key" => "title_tag",
		    "ownerType" => "COLLECTION",
	    ]
    );
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Shopify $shopify)
    {
        parent::__construct();
        
        $this->shopify = $shopify;
    }
	
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$gql = 'mutation($input: MetafieldStorefrontVisibilityInput!) {
				  metafieldStorefrontVisibilityCreate(input: $input) {
				    metafieldStorefrontVisibility {
				      id
				    }
				    userErrors {
				      field
				      message
				    }
				  }
				}';
    	
    	
    	foreach($this->fields as $field) {
		    $variables = ["input" => $field];
		    
		    $r = $this->shopify->query($gql, $variables);
	    }
    }
    
}


