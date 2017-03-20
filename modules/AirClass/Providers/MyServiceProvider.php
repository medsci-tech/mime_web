<?php namespace Modules\Airclass\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\AirClass\Entities\Keyword;
class MyServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $keywords = Keyword::all()->toArray();
        view()->composer('*',function($view) use ($keywords) {
            $view->with('keywords',$keywords);
        });

    }


    /**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
