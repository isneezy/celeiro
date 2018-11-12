<?php

namespace Isneezy\Celeiro\Tests;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Isneezy\Celeiro\Filterable\Filterable;
use Isneezy\Celeiro\Repository;

class RepositoryTest extends TestCase {
	/** @var \ReflectionClass */
	private $reflection;

	/**
	 * @throws \ReflectionException
	 */
	protected function setUp() {
		parent::setUp();
		$this->makeRepository();
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
		$filterable = Filterable::builder()->toFilterable();
		$method = $this->reflection->getMethod('doQuery');
		$method->setAccessible(true);
		$result = $method->invokeArgs($repository, [$repository->newQuery(), $filterable]);
		self::assertInstanceOf(LengthAwarePaginator::class, $result);
	}
}