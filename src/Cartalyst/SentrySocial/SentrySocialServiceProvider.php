<?php namespace Cartalyst\SentrySocial;
/**
 * Part of the Sentry Social package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sentry
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\SentrySocial\Storage\EloquentStorage;
use OAuth\Common\Storage\Memory as MemoryStorage;
use OAuth\Common\Storage\Session as SessionStorage;
use illuminate\Support\ServiceProvider;

class SentrySocialServiceProvider extends ServiceProvider {

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('cartalyst/sentrysocial', 'cartalyst/sentrysocial');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// The "service provider" in this context is the
		// class which provides a service object.
		$this->registerServiceProvider();

		$this->registerStorage();

		$this->registerSentrySocial();
	}

	/**
	 * Registers the OAuth service factory.
	 *
	 * @return void
	 */
	protected function registerServiceProvider()
	{
		$this->app['sentrysocial.provider'] = $this->app->share(function($app)
		{
			return new ServiceProvider;
		});
	}

	protected function registerStorage()
	{
		// We are not sharing a singleton, we will return
		// a new instance each time.
		$this->app['sentrysocial.storage'] = function($app)
		{
			$storage = $app['config']['cartalyst/sentrysocial::storage'];

			switch ($storage)
			{
				case 'eloquent':
					$model = $app['config']['cartalyst/sentrysocial::model'];
					return new EloquentStorage($model);

				// @todo Add an illuminate/session storage engine.
				case 'session':
					return new SessionStorage(true, 'cartalyst_sentry_social_token');
					break;

				case 'memory':
					return new MemoryStorage;
					break;
			}

			throw new \InvalidArgumentException("Invalid storage driver [$storage] chosen.");
		};
	}

	/**
	 * Registers Sentry Social.
	 *
	 * @return void
	 */
	protected function registerSentrySocial()
	{
		$this->app['sentrysocial'] = $this->app->share(function($app)
		{
			return new Manager($app['sentrysocial.provider']);
		});
	}

}