<?php

namespace Isneezy\Celeiro\Contracts;


interface IFilterable {
	/**
	 * Returns the page to be returned.
	 * @return int
	 */
	public function getPage();

	/**
	 * Returns the number of items to be returned.
	 * @return int
	 */
	public function getPageSize();

	/**
	 * Returns the offset for manual pagination
	 * @return int
	 */
	public function getOffSet();

//	/**
//	 * Returns the current $sort or the given one if the current one is unsorted.
//	 * @param Sort|null $sort
//	 * @return Sort
//	 */
//	public function getSort($sort = null);

	/**
	 * Returns whether the current Pageable contains pagination information.
	 * @return bool
	 */
	public function isPaged();

	/**
	 * Returns whether the current Pageable does not contain pagination information.
	 * @return bool
	 */
	public function isUnPaged();

	/**
	 * Returns the query string used for search
	 * @return string
	 */
	public function getSearchParam();

	/**
	 * Returns an array of relations that should be eager loaded
	 * @return array
	 */
	public function getInclude();

	/**
	 * Returns param defined in key or default if it does not extist and all params array if $key is null
	 * @param $key
	 * @param $default
	 *
	 * @return mixed
	 */
	public function get($key = null, $default = null);

	/**
	 * @return array
	 */
	public function getOrder();

//	/**
//	 * Returns filters for the query
//	 * @return Filters
//	 */
//	public function filters();

//	/**
//	 * Returns the base path for paginator links
//	 * @return string
//	 */
//	public function getBasePath();
}