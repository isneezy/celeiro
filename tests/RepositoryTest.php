<?php

namespace Isneezy\Celeiro\Tests;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
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
		$repository = new Repository();
		$this->reflection = new \ReflectionClass($repository);

		$modelClass = $this->reflection->getProperty('modelClass');
		$modelClass->setAccessible(true);
		$modelClass->setValue($repository, TestModel::class);
		return $repository;
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_newQuery () {
		$repository = $this->makeRepository();
		$query = $repository->newQuery();
		self::assertInstanceOf(Builder::class, $query);
		self::assertEquals('select * from "tests"', $query->toSql());
	}

	/**
	 * @throws \ReflectionException
	 */
	public function test_doQuery() {
		$repository = $this->makeRepository();
		$filterable = \Isneezy\Celeiro\Filterable\Filterable::builder()->toFilterable();
		$method = $this->reflection->getMethod('doQuery');
		$method->setAccessible(true);
		$result = $method->invokeArgs($repository, [$repository->newQuery(), $filterable]);
		self::assertInstanceOf(LengthAwarePaginator::class, $result);
	}
}