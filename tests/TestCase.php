<?php

namespace Isneezy\Celeiro\Tests;


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Isneezy\Celeiro\Provider\LaravelServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase {
	protected function setUp() {
		parent::setUp();
		Schema::create('tests', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
		});
		Schema::create('test_relations', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('model_id');
		});
	}

	protected function tearDown() {
		Schema::drop('test_relations');
		Schema::drop('tests');
		parent::tearDown();
	}

	/**
	 * Load package service provider
	 * @param \Illuminate\Foundation\Application $app
	 *
	 * @return array
	 */
	protected function getPackageProviders( $app ) {
		return [LaravelServiceProvider::class];
	}

	public function resetDB() {
		DB::raw('delete from tests');
	}
}