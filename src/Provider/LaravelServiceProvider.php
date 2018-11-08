<?php

namespace Isneezy\Celeiro\Provider;


class LaravelServiceProvider extends CeleiroServiceProvider {
	public function boot() {
		$resourcesDir = __DIR__ . '/../resources';
		$this->publishes( [ "$resourcesDir/config/celeiro.php" => config_path( 'celeiro.php' ) ] );
	}
}