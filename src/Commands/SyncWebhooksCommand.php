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

class SyncWebhooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shopify:webhooks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync shopify webhooks';

    private $shopify;

    private $hooks = [
    	'shopify.webhooks.collection.update' => 'COLLECTIONS_UPDATE',
	    'shopify.webhooks.collection.create' => 'COLLECTIONS_CREATE',
	    'shopify.webhooks.collection.delete' => 'COLLECTIONS_DELETE',
	
	    'shopify.webhooks.product.update' => 'PRODUCTS_UPDATE',
	    'shopify.webhooks.product.create' => 'PRODUCTS_CREATE',
	    'shopify.webhooks.product.delete' => 'PRODUCTS_DELETE',
    ];
    
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
    	//$this->deleteWebhooks();
	    
    	$this->createWebhooks();
    }
    
    protected function createWebhooks()
    {
	    foreach($this->hooks as $hook => $action) {
		    $route = route($hook);
		    $url = str_replace('http://localhost', 'https://app.driftfreediving.com', $route);
		
		    $this->shopify->webhooks->create($url, $action);
		    $this->info("Created webhook for: " . $action);
	    }

    }
    
    protected function deleteWebhooks()
    {
        $hooks = $this->shopify->webhooks->all();
        dd($hooks);
    }
}


