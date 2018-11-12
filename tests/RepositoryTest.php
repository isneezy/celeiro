<?php

namespace Isneezy\Celeiro\Tests;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Isneezy\Celeiro\Filterable\Filterable;
use Isneezy\Celeiro\Filterable\FilterableFactory;
use Isneezy\Celeiro\Repository;
use Isneezy\Celeiro\Tests\Models\TestModel;
use Isneezy\Celeiro\Tests\Models\TestRelationModel;

class RepositoryTest extends TestCase {
	/** @var \ReflectionClass */
	private $reflection;
	private $doQuery;

	/**
	 * @throws \ReflectionException
	 */
	protected function setUp() {
		parent::setUp();
		$this->makeRepository();
		$this->doQuery = $this->reflection->getMethod('doQuery');
		$this->doQuery->setAccessible(true);
	}

	/**
	 * @return Repository
	 * @throws \ReflectionException
	 */
	public function makeRepository() {
		/** @var Repository $repository */
		$repository = $this->getMockBuilder(Repository::class)->getMockForAbstractClass();
		$this->reflection = new \ReflectionClass($repository);

		$modelClass = $this->reflection->getProperty('modelClass');
		$modelClass->setAccessible(true);
		$modelClass->setValue($repository, TestModel::class);
		return $repository;
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_it_can_create_query () {
		$repository = $this->makeRepository();
		$query = $repository->newQuery();
		self::assertInstanceOf(Builder::class, $query);
		self::assertEquals('select * from "tests"', $query->toSql());
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_it_can_execute_query() {
		$repository = $this->makeRepository();
		$filterable = FilterableFactory::fromRequest()->make();
		$result = $this->doQuery->invokeArgs($repository, [$repository->newQuery(), $filterable]);
		self::assertInstanceOf(LengthAwarePaginator::class, $result);
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_it_can_include_relations () {
		TestModel::insert(['name' => 'Ivan']);
		TestRelationModel::insert(['name' => 'Ivan\'s Test Relation', 'model_id' => 1]);
		$repository = $this->makeRepository();
		$filterable = FilterableFactory::fromRequest()->include(['test_relation'])->make();
		$result = $this->doQuery->invokeArgs($repository, [$repository->newQuery(), $filterable]);
		self::assertTrue($result->first()->relationLoaded('test_relation'), 'Failed to assert that test_relation was loaded');
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_it_order_results () {
		TestModel::insert(['name' => 'Ivan']);
		TestModel::insert(['name' => 'Ivan 2']);
		TestModel::insert(['name' => 'Ivan 3']);

		$repository = $this->makeRepository();
		$filterable = FilterableFactory::fromRequest()->order('id', 'DESC')->make();
		$result = $this->doQuery->invokeArgs($repository, [$repository->newQuery(), $filterable]);
		self::assertEquals(3, $result->first()->id);
	}
}