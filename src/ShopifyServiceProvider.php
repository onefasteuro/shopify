<?php

namespace onefasteuro\Shopify;


use Illuminate\Support\ServiceProvider;
use onefasteuro\Shopify\Commands\SyncShopifyCommand;
use onefasteuro\Shopify\Commands\SyncWebhooksCommand;
use onefasteuro\Shopify\Controllers\WebhooksController;
use onefasteuro\Shopify\Throttles\StorefrontThrottle;
use onefasteuro\Shopify\Throttles\Throttle;


class ShopifyServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }








    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/shopify.php', 'shopify');
	
	    $this->app->singleton(Throttle::class, function($app){
		    return new Throttle;
	    });
	
	    $this->app->singleton(StorefrontThrottle::class, function($app){
		    return new StorefrontThrottle;
	    });

        $this->app->singleton(Shopify::class, function($app){

            $config = $app['config'];

            $type = $config->get('shopify.type');

            $endpoints = $config->get('shopify.endpoints');
            
            if($type === 'private') {
                $key = $config->get('shopify.api_key');
                $secret = $config->get('shopify.api_secret');

                $headers = ['Content-Type' => 'application/json', 'X-Shopify-Access-Token' => $secret, 'X-GraphQL-Cost-Include-Fields' => true];

                $url = 'https://' . $config->get('shopify.shop') . '/admin/api/2019-07/';

                $client = new \Requests_Session($url, $headers);
            }
            else {

            }

            return new Shopify($client, $app['events'], $endpoints, $app[Throttle::class]);
        });


        $this->app->singleton(Storefront::class, function($app){
            $config = $app['config'];
            $token = $config->get('shopify.storefront_token');
            $headers = ['Content-Type' => 'application/json', 'X-Shopify-Storefront-Access-Token' => $token];
            $url = 'https://' . $config->get('shopify.shop') . '/api/graphql';

            $client = new \Requests_Session($url, $headers);

            return new Storefront($client, $app[StorefrontThrottle::class]);
        });


        $this->registerControllers();

        $this->app->register(ShopifyEventsServiceProvider::class);
    }


    /**
     * Register our controllers
     */
    protected function registerControllers()
    {
        $this->app->singleton(WebhooksController::class, function($app){
            return new WebhooksController($app[Shopify::class]);
        });
    }
    

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['shopify'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/shopify.php' => config_path('shopify.php'),
        ], 'shopify.config');
	
	    $this->commands([
		    SyncShopifyCommand::class,
		    SyncWebhooksCommand::class,
	    ]);
    }
}
