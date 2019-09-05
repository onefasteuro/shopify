<?php

namespace onefasteuro\Shopify\Commands;

use Illuminate\Console\Command;
use onefasteuro\Shopify\Exceptions\ShopifyThrottleException;
use onefasteuro\Shopify\Models\CollectionProduct;
use onefasteuro\Shopify\Models\Product;
use onefasteuro\Shopify\Models\ProductTag;
use onefasteuro\Shopify\Models\SkuInventory;
use onefasteuro\Shopify\Queries\CollectionQuery;
use onefasteuro\Shopify\Queries\ProductQuery;
use onefasteuro\Shopify\Shopify;
use onefasteuro\Shopify\Models\Collection;
use onefasteuro\Shopify\Storefront;

//JOBS
use onefasteuro\Shopify\Jobs\Storefront\SaveCollection;
use onefasteuro\Shopify\Jobs\Storefront\SaveProduct;

class SyncShopifyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shopify:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync shopify collections and products data';

    private $shopify;
    private $storefront;
    private $products_count = 0;
    private $collections_count = 0;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Shopify $shopify, Storefront $storefront)
    {
        parent::__construct();

        $this->shopify = $shopify;
        $this->storefront = $storefront;
        
        dd(1);
    }


    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->truncateTables();

        $this->syncCollections();
        $this->output->write("\n");
        $this->info("Processed " . $this->collections_count . "Collection records");
        $this->output->write("\n");


        $this->output->write("........................................ \n\n");

        $this->syncProducts();
        $this->output->write("\n");
        $this->info("Processed " . $this->products_count . "Product records");
        $this->output->write("\n");
    }

    public function truncateTables()
    {

        Product::truncate();
        ProductTag::truncate();
        CollectionProduct::truncate();
        Collection::truncate();
        SkuInventory::truncate();
    }

    public function syncProducts()
    {
        $this->info('Synching Shopify Products');

        $cursor = null;

        try {
            do{
                $r = $this->storefront->query(ProductQuery::get('storefrontQuery'), ['l' => 250, 'n' => $cursor]);
                $results = $r['data']['products'];
                $this->loopProducts($results['edges']);
                $last_element = end($results['edges']);
                $cursor = $last_element['cursor'];
            }
            while($results['pageInfo']['hasNextPage'] === true);
        }
        catch(ShopifyThrottleException $e) {
            $this->error($e->getMessage());
        }
    }
    
    public function loopProducts($results)
    {
	    foreach($results as $result) {
		    dispatch(new SaveProduct($result['node']));
		    $this->output->write('.');
            $this->products_count += 1;
	    }
    }

    public function syncCollections()
    {
        $this->info('Synching Shopify Collections');

        $cursor = null;

        do {
            $r = $this->storefront->query(CollectionQuery::get('storefrontQuery'), ["l" => 25, "n" => $cursor]);
            $results = $r['data']['collections'];
            $this->loopCollections($results['edges']);

            $last_element = end($results['edges']);
            $cursor = $last_element['cursor'];
        }
        while($results['pageInfo']['hasNextPage'] === true);
    }

    public function loopCollections($results)
    {
        foreach($results as $result) {

            dispatch(new SaveCollection($result['node']));
            $this->output->write('.');
            $this->collections_count += 1;
        }
    }



}


