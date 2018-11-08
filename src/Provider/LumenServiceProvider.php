<?php

namespace Isneezy\Celeiro\Provider;


class LumenServiceProvider extends CeleiroServiceProvider {
	public function boot() {
		parent::boot();
		$this->app->configure('celeiro');
	}
}