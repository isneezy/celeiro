<?php

namespace Isneezy\Celeiro;


class LumenServiceProvider extends ServiceProvider {
	public function boot() {
		parent::boot();
		$this->app->configure('celeiro');
	}
}