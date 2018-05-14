<?php

namespace Isneezy\Celeiro\Filterable;


use Illuminate\Support\Arr;
use Isneezy\Celeiro\Contracts\Filterable as FilterableContract;

class Filterable implements FilterableContract {

	protected $params = [];

	public function setParam($name, $value) {
		$this->params[$name] = $value;
	}

	public function setParams (array $params) {
		$this->params = $params;
	}

	/**
	 * Returns the page to be returned.
	 * @return int
	 */
	public function pageNumber() {
		return Arr::get($this->params, 'page', 1);
	}

	/**
	 * Returns the number of items to be returned.
	 * @return int
	 */
	public function getPageSize() {
		return Arr::get($this->params, 'limit', 10);
	}

	/**
	 * Returns the offset for manual pagination
	 * @return int
	 */
	public function getOffSet() {
		return ( $this->pageNumber() - 1 ) * $this->getPageSize();
	}

	/**
	 * Returns whether the current Pageable contains pagination information.
	 * @return bool
	 */
	public function isPaged() {
		return Arr::get($this->params, 'paged', true) ? true : false;
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
		return Arr::get($this->params, 'q', '');
	}

	/**
	 * creates a Filterable builder
	 *
	 * @return Builder
	 */
	public static function builder() {
		return new Builder();
	}
}