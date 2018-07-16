<?php

namespace Isneezy\Celeiro;


use Illuminate\Container\Container;
use Isneezy\Celeiro\Contracts\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Repository {

	/**
	 * The model class for this repo.
	 * @var string
	 */
	protected $modelClass;

	/**
	 * Creates a new query
	 * @return Builder
	 */
	public function newQuery() {
		return Container::getInstance()->make( $this->modelClass )->newQuery();
	}

	/**
	 * @param Builder | \Illuminate\Database\Query\Builder $query
	 * @param Filterable $filterable
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
	 */

	protected function doQuery( $query, $filterable) {
		if ( is_null( $query ) ) {
			$query = $this->newQuery();
		}

		if ( true === $filterable->isPaged() ) {
			$paginator = $query->paginate( $filterable->getPageSize() );
			$paginator->appends(request()->except(['page']));
			return $paginator;
		}

		if ( $filterable->getPageSize() > 0) {
			return $query->take( $filterable->getPageSize() )->get();
		}

		return $query->get();
	}

	/**
	 * Creates a model with the $data information in it
	 *
	 * @param array $data
	 *
	 * @return Model
	 */
	public function factory( array $data ) {
		$model = $this->newQuery()->getModel()->newInstance();
		$this->setModelData( $model, $data );

		return $model;
	}
}