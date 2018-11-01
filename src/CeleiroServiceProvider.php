<?php

namespace Isneezy\Celeiro;


class CeleiroServiceProvider extends ServiceProvider {
	public function boot() {
		$resourcesDir = __DIR__ . '/../resources';
		$this->publishes( [ "$resourcesDir/config/celeiro.php" => config_path( 'celeiro.php' ) ] );
	}
}