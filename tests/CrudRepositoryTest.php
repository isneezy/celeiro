<?php

namespace Isneezy\Celeiro\Tests;


use Illuminate\Support\Facades\DB;
use Isneezy\Celeiro\Contracts\Filterable;
use Isneezy\Celeiro\CrudRepository;

class CrudRepositoryTest extends TestCase {
	/** @var CrudRepository */
	private $repository;

	protected function setUp() {
		parent::setUp();
		$this->repository = $this->getMockForAbstractClass(CrudRepository::class);
		$reflection = new \ReflectionClass($this->repository);
		$modelClass = $reflection->getProperty('modelClass');
		$modelClass->setAccessible(true);
		$modelClass->setValue($this->repository, TestModel::class);
	}

	public function test_create () {
		self::assertInstanceOf(TestModel::class, $this->repository->create(['name' => 'John Doe']));
		$this->assertDatabaseHas('tests', ['name' => 'John Doe']);
	}

	public function test_findAll () {
		$this->repository->create(['name' => 'John Doe']);
		$this->repository->create(['name' => 'John HERN']);
		$filterable = \Isneezy\Celeiro\Filterable\Filterable::builder()->paged(false)->limit(0)->toFilterable();
		$res = $this->repository->findAll($filterable);
		self::assertEquals(2, $res->count());
	}

	public function test_findById () {
		TestModel::insert([
			['name' => 'Ivan'],
			['name' => 'Adelino'],
			['name' => 'Edgencio'],
		]);
		self::assertEquals('Ivan', $this->repository->findByID(1)->name);
	}

	public function test_update () {
		$model = $this->repository->create(['name' => 'Ivan']);
		$this->repository->update($model, ['name' => 'Ivan Vilanculo']);
		$this->assertDatabaseHas('tests', ['name' => 'Ivan Vilanculo']);
	}

	public function test_delete () {
		$model = $this->repository->create(['name' => 'Ivan']);
		$this->repository->delete($model->id);
		$this->assertDatabaseMissing('tests', ['name' => 'Ivan']);
	}
}