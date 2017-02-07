<?php namespace Justincdotme\OpenCharge\Providers;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;

class OpenChargeServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the configuration
     *
     * @return void
     */
    public function boot()
    {
        $source = dirname(dirname(__DIR__)).'/config/opencharge.php';
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('opencharge.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            //TODO - Create config dir and copy file to allow user editing should base URL ever change.
            $this->app->configure('opencharge');
        }
        $this->mergeConfigFrom($source, 'opencharge');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Justincdotme\OpenCharge\Interfaces\HttpClientInterface::class,
            \Justincdotme\OpenCharge\HttpClientAdapter::class
        );
        $this->app->singleton('openCharge',function($app)
        {
            return $app->make(\Justincdotme\OpenCharge\OpenCharge::class);
        });

        if ($this->app instanceof LaravelApplication) {
            $this->app->booting(function ()
            {
                $loader = \Illuminate\Foundation\AliasLoader::getInstance();
                $loader->alias('openCharge', $this->app->make(\Justincdotme\OpenCharge\Facades\OpenCharge::class));
            });
        }
    }
}