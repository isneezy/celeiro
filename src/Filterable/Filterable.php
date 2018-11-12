<?php

namespace Isneezy\Celeiro\Filterable;


use Illuminate\Support\Arr;
use Isneezy\Celeiro\Contracts\IFilterable as FilterableContract;

class Filterable implements FilterableContract {

	protected $params = [];

	public function setParam( $name, $value ) {
		$this->params[ $name ] = $value;
	}

	public function setParams( array $params ) {
		$this->params = $params;
	}

	/**
	 * Returns the page to be returned.
	 * @return int
	 */
	public function getPage() {
		return Arr::get( $this->params, config('celeiro.params.page'), 1 );
	}

	/**
	 * Returns the number of items to be returned.
	 * @return int
	 */
	public function getPageSize() {
		return Arr::get( $this->params, config('celeiro.params.limit'), 10 );
	}

	/**
	 * Returns the offset for manual pagination
	 * @return int
	 */
	public function getOffSet() {
		return ( $this->getPage() - 1 ) * $this->getPageSize();
	}

	/**
	 * Returns whether the current Pageable contains pagination information.
	 * @return bool
	 */
	public function isPaged() {
		return Arr::get( $this->params, config('celeiro.params.paged'), true ) ? true : false;
	}

	/**
	 * Returns whether the current Pageable does not contain pagination information.
	 * @return bool
	 */
	public function isUnPaged() {
		return ! $this->isPaged();
	}

	/**
	 * Returns the query string used for search
	 * @return string
	 */
	public function getSearchParam() {
		return Arr::get( $this->params, config('celeiro.params.search'), '' );
	}

	/**
	 * Returns param defined in key or default if it does not extist and all params array if $key is null
	 *
	 * @param $key
	 * @param $default
	 *
	 * @return mixed
	 */
	public function get( $key = null, $default = null ) {
		if (empty($key)) {
			return $this->params;
		}
		return Arr::get($this->params, $key, $default);
	}


	/*
	 * ->paged( ! $request->has( 'unpaged') )
			                 ->page( $request->get( 'page', 1 ) )
			                 ->limit($request->get('limit', config('celeiro.limit')) )
			                 ->search( $request->get( 'q', '' ) )
	 */
	/**
	 * Returns an array of relations that should be eager loaded
	 * @return array
	 */
	public function getInclude() {
		return array_filter(explode(',', array_get($this->params, config('celeiro.params.include'))));
	}

	/**
	 * @return array
	 */
	public function getOrder() {
		return explode(',', Arr::get($this->params, config('celeiro.params.order')));
	}
}