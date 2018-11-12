<?php
namespace Isneezy\Celeiro\Tests\Filterable;
use Illuminate\Http\Request;
use Isneezy\Celeiro\Contracts\IFilterable;
use Isneezy\Celeiro\Filterable\FilterableFactory;
use Isneezy\Celeiro\Tests\TestCase;

class FilterableFactoryTest extends TestCase {

	public function test_page () {
		$filterable = $this->app[IFilterable::class];
		$filterable = FilterableFactory::fromFilterable($filterable)->page(40)->make();
		self::assertEquals(40, $filterable->getPage());
	}

	public function test_limit () {
		$filterable = $this->app[IFilterable::class];
		$filterable = FilterableFactory::fromFilterable($filterable)->limit(20)->make();
		self::assertEquals(20, $filterable->getPageSize());
	}

	public function test_paged () {
		$filterable = FilterableFactory::fromRequest($this->app['request'])->paged(false)->make();
		self::assertFalse($filterable->isPaged());
		self::assertTrue($filterable->isUnPaged());
	}

	public function test_search () {
		$filterable = FilterableFactory::fromRequest($this->app['request'])->search('hello world')->make();
		self::assertEquals('hello world', $filterable->getSearchParam());
	}

	public function test_it_can_create_from_request () {
		/** @var Request $request */
		$request = $this->app[Request::class];
		$request = $request->merge(['page' => 21, 'limit' => 40, 'q' => 'hello']);
		$filterable = FilterableFactory::fromRequest($request)->make();
		self::assertEquals(21, $filterable->getPage());
		self::assertEquals(40, $filterable->getPageSize());
		self::assertEquals('hello', $filterable->getSearchParam());
	}

	public function test_it_can_get_request_params () {
		/** @var Request $request */
		$request = $this->app[Request::class];
		$request = $request->merge(['param' => 'param_value']);
		$filterable = FilterableFactory::fromRequest($request)->make();
		self::assertArrayHasKey('param', $filterable->get());
		self::assertEquals('param_value', $filterable->get('param'));
		self::assertEquals('param_value', $filterable->get('param_1', 'param_value'));
	}

	public function test_it_can_create_from_filterable () {
		$request = $this->app[Request::class];
		$request = $request->merge(['param' => 'param_value']);
		$filterable = FilterableFactory::fromRequest($request)->make();
		$filterable = FilterableFactory::fromFilterable($filterable)->page(12)->make();
		self::assertEquals('param_value', $filterable->get('param'));
		self::assertEquals(12, $filterable->getPage());
	}
}