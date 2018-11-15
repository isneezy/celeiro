<?php

namespace Isneezy\Celeiro\Tests;

use Isneezy\Celeiro\CrudRepository;
use Isneezy\Celeiro\Filterable\FilterableFactory;
use Isneezy\Celeiro\Tests\Models\TestModel;

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

	public function test_it_can_create () {
		self::assertInstanceOf(TestModel::class, $this->repository->create(['name' => 'John Doe']));
		$this->assertDatabaseHas('tests', ['name' => 'John Doe']);
	}

	public function test_it_can_find_all () {
		$this->repository->create(['name' => 'John Doe']);
		$this->repository->create(['name' => 'John HERN']);
		$res = $this->repository->findAll();
		self::assertEquals(2, $res->count());
	}

	public function test_it_can_find_by_id () {
		TestModel::insert([
			['name' => 'Ivan'],
			['name' => 'Adelino'],
			['name' => 'Edgencio'],
		]);
		self::assertEquals('Ivan', $this->repository->findByID(1)->name);
	}

	public function test_it_can_update () {
		$model = $this->repository->create(['name' => 'Ivan']);
		$this->repository->update($model, ['name' => 'Ivan Vilanculo']);
		$this->assertDatabaseHas('tests', ['name' => 'Ivan Vilanculo']);
	}

	public function test_it_can_delete () {
		$model = $this->repository->create(['name' => 'Ivan']);
		$this->repository->delete($model->id);
		$this->assertDatabaseMissing('tests', ['name' => 'Ivan']);
	}

	public function test_it_can_find_one_by_any_column () {
		$this->repository->create(['name' => 'Ivan']);
		$this->repository->create(['name' => 'Ivan2']);
		$model = $this->repository->findBy('name', 'Ivan');
		self::assertNotNull($model);
		self::assertEquals($model->getAttribute('name'), 'Ivan');

		$model = $this->repository->findBy(['name' => 'Ivan']);
		self::assertNotNull($model);
		self::assertEquals($model->getAttribute('name'), 'Ivan');
	}

	public function test_it_can_find_many_by_any_column () {
		$this->repository->create(['name' => 'Ivan']);
		$this->repository->create(['name' => 'Ivan']);
		$this->repository->create(['name' => 'Ivan2']);

		$model = $this->repository->findManyBy('name','Ivan');
		self::assertEquals(2, $model->count());

		$model = $this->repository->findManyBy(['name' => 'Ivan2']);
		self::assertEquals(1, $model->count());
	}
}