<?php

namespace Isneezy\Celeiro\Filterable;


use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Isneezy\Celeiro\Contracts\IFilterable;

class FilterableFactory {
	protected $params = [];

	/**
	 * @param Request | null $request
	 *
	 * @return FilterableFactory
	 */
	public static function fromRequest( $request = null ) {
		if ( empty( $request ) ) {
			$request = app( 'request' );
		}
		$params = $request->all();

		return new FilterableFactory( $params );
	}

	public static function fromFilterable( Filterable $filterable ) {
		$params = $filterable->get();
		return new FilterableFactory($params);
	}

	private function __construct( $params ) {
		if ( $params instanceof IFilterable ) {
			$params = $params->get();
		}
		$this->params = $params;
	}

	/**
	 * @param $page int
	 *
	 * @return FilterableFactory
	 */
	public function page( $page ) {
		$this->params['page'] = $page;

		return $this;
	}

	/**
	 * @param $limit
	 *
	 * @return $this
	 */
	public function limit( $limit ) {
		$this->params['limit'] = $limit;

		return $this;
	}

	/**
	 * @param $paged bool
	 *
	 * @return FilterableFactory
	 */
	public function paged( $paged ) {
		$this->params['paged'] = $paged;

		return $this;
	}

	/**
	 * @param $q string
	 *
	 * @return FilterableFactory
	 */
	public function search( $q ) {
		$this->params['q'] = $q;

		return $this;
	}

	/**
	 * @param $include array | string
	 * @param bool $override
	 *
	 * @return FilterableFactory
	 */
	public function include ($include, $override = false) {
		$oldInclude = explode(',', Arr::get($this->params, 'include', null));
		if (is_string($include)) {
			$include = explode(',', $include);
		}
		if (!$override) {
			$include = array_merge($oldInclude, $include);
		}
		$this->params['include'] = implode(',', array_filter(array_unique($include)));
		return $this;
	}

	public function make() {
		$filterable = new Filterable();
		$filterable->setParams( $this->params );

		return $filterable;
	}

	public function order( $column, $direction ) {
		$this->params['order'] = "$column,$direction";
		return $this;
	}
}