<?php

namespace Isneezy\Celeiro\Filterable;


use Illuminate\Http\Request;
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

	public function make() {
		$filterable = new Filterable();
		$filterable->setParams( $this->params );

		return $filterable;
	}
}