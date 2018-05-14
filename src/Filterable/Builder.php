<?php

namespace Isneezy\Celeiro\Filterable;


class Builder {
	protected $params = [];

	/**
	 * @param $page int
	 *
	 * @return Builder
	 */
	public function page($page) {
		$this->params['page'] = $page;
		return $this;
	}

	/**
	 * @param $limit
	 *
	 * @return $this
	 */
	public function limit($limit) {
		$this->params['limit'] = $limit;
		return $this;
	}

	/**
	 * @param $paged bool
	 *
	 * @return Builder
	 */
	public function paged($paged) {
		$this->params['paged'] = $paged;
		return $this;
	}

	/**
	 * @param $q string
	 *
	 * @return Builder
	 */
	public function search($q) {
		$this->params['q'] = $q;
		return $this;
	}

	public function toFilterable() {
		$filterable = new Filterable();
		$filterable->setParams($this->params);
		return $filterable;
	}
}