<?php

namespace Isneezy\Celeiro\Provider;


use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider as Service;
use Isneezy\Celeiro\Contracts\Filterable as FilterableContract;
use Isneezy\Celeiro\Filterable\Filterable;

class CeleiroServiceProvider extends Service {

	public function boot() {
		$this->mergeConfigFrom( __DIR__.'/../resources/config/celeiro.php', 'celeiro');
	}

	public function register() {
		$this->app->bind( FilterableContract::class, function () {
			$request = Container::getInstance()->make( Request::class );

			return Filterable::builder()
			                 ->paged( ! $request->has( 'unpaged') )
			                 ->page( $request->get( 'page', 1 ) )
			                 ->limit($request->get('limit', config('celeiro.limit')) )
			                 ->search( $request->get( 'q', '' ) )
			                 ->toFilterable();
		} );
	}
}