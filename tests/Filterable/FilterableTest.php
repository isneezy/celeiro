<?php

namespace Isneezy\Celeiro\Tests\Filterable;


use Isneezy\Celeiro\Filterable\Filterable;
use Isneezy\Celeiro\Tests\TestCase;

class FilterableTest extends TestCase {
	/** @var Filterable */
	private $filterable;
	private $params = [
		'page' => 10,
		'limit' => 12,
		'paged' => true,
		'q' => 'hello',
		'other' => null
	];

	public function setUp() {
		parent::setUp();
		$this->filterable = $this->makeFilterable();
		$this->filterable->setParams($this->params);
	}

	public function test_setParams () {
		$filtrable = $this->makeFilterable();
		$filtrable->setParams($this->params);
		self::assertEquals(10, $filtrable->pageNumber());
		self::assertEquals(12, $filtrable->getPageSize());
		self::assertTrue($filtrable->isPaged());
		self::assertEquals('hello', $filtrable->getSearchParam());
	}

	public function test_setParam () {
		$filterable = $this->makeFilterable();
		$filterable->setParam('page', 12);
		$filterable->setParam('limit', 45);
		self::assertEquals(12, $filterable->pageNumber());
		self::assertEquals(45, $filterable->getPageSize());
	}

	public function test_pageNumber () {
		$this->filterable->setParams($this->params);
		self::assertEquals(10, $this->filterable->pageNumber());
	}

	public function test_pageSize () {
		$this->filterable->setParams($this->params);
		self::assertEquals(12, $this->filterable->getPageSize());
	}

	public function test_pageOffSet () {
		$this->filterable->setParams($this->params);
		self::assertEquals(108, $this->filterable->getOffSet());
	}

	public function test_isPaged () {
		$this->filterable->setParams($this->params);
		self::assertTrue($this->filterable->isPaged());
		$this->filterable->setParams(array_merge($this->params, ['paged' => false]));
		self::assertFalse($this->filterable->isPaged());
	}

	public function test_isUnPaged () {
		$this->filterable->setParams($this->params);
		self::assertFalse($this->filterable->isUnPaged());
		$this->filterable->setParams(array_merge($this->params, ['paged' => false]));
		self::assertTrue($this->filterable->isUnPaged());
	}

	public function test_getSearchParam () {
		$this->filterable->setParams($this->params);
		self::assertEquals('hello', $this->filterable->getSearchParam());
	}

	public function makeFilterable () {
		return new Filterable();
	}
}