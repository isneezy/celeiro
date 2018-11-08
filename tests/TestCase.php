<?php

namespace Isneezy\Celeiro\Tests;


use Isneezy\Celeiro\Provider\LaravelServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase {
	/**
	 * Load package service provider
	 * @param \Illuminate\Foundation\Application $app
	 *
	 * @return array
	 */
	protected function getPackageProviders( $app ) {
		return [LaravelServiceProvider::class];
	}
}