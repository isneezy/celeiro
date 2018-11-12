<?php

namespace Isneezy\Celeiro\Provider;


use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider as Service;
use Isneezy\Celeiro\Contracts\IFilterable as FilterableContract;
use Isneezy\Celeiro\Filterable\Filterable;
use Isneezy\Celeiro\Filterable\FilterableFactory;

class CeleiroServiceProvider extends Service {
	public function register() {
		$this->mergeConfigFrom( __DIR__.'/../../resources/config/celeiro.php', 'celeiro');
		$this->app->bind( FilterableContract::class, function () {
			$request = Container::getInstance()->make( Request::class );
			return FilterableFactory::fromRequest($request)->make();
		} );
	}
}