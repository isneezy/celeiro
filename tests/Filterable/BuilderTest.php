<?php
namespace Isneezy\Celeiro\Tests\Filterable;
use Isneezy\Celeiro\Filterable\Filterable;
use Isneezy\Celeiro\Tests\TestCase;

class BuilderTest extends TestCase {
	/**
	 * @return \Isneezy\Celeiro\Filterable\Builder
	 */
	private function makeBuilder() {
		return Filterable::builder();
	}

	public function test_page () {
		$filterable = $this->makeBuilder()->page(40)->toFilterable();
		self::assertEquals(40, $filterable->pageNumber());
	}

	public function test_limit () {
		$filterable = $this->makeBuilder()->limit(20)->toFilterable();
		self::assertEquals(20, $filterable->getPageSize());
	}

	public function test_paged () {
		$filterable = $this->makeBuilder()->paged(false)->toFilterable();
		self::assertFalse($filterable->isPaged());
		self::assertTrue($filterable->isUnPaged());
	}

	public function test_search () {
		$filterable = $this->makeBuilder()->search('hello world')->toFilterable();
		self::assertEquals('hello world', $filterable->getSearchParam());
	}
}