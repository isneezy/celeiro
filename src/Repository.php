<?php

namespace Isneezy\Celeiro;


use Illuminate\Container\Container;
use Illuminate\Support\Arr;
use Isneezy\Celeiro\Contracts\IFilterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Isneezy\Celeiro\Contracts\IRepository;

abstract class Repository implements IRepository {

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
	 * @param IFilterable $filterable
	 *
	 * @param bool $first
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]| Model
	 */

	protected function doQuery( $query, $filterable, $first = false ) {
		if ( is_null( $query ) ) {
			$query = $this->newQuery();
		}

		$this->loadRelations($query, $filterable);
		$this->orderResults($query, $filterable->getOrder());

		if ($first) {
			return $query->first();
		}

		if ( true === $filterable->isPaged() ) {
			$paginator = $query->paginate( $filterable->getPageSize() );
			$paginator->appends( app( 'request' )->except( [ 'page' ] ) );

			return $paginator;
		}

		if ( $filterable->getPageSize() > 0 ) {
			return $query->take( $filterable->getPageSize() )->get();
		}

		return $query->get();
	}

	protected function loadRelations(Builder $query, IFilterable $filterable) {
		return $query->with($filterable->getInclude());
	}

	private function orderResults(Builder $query, array $order) {
		if (count($order)) {
			$query->orderBy(Arr::get($order, 0), Arr::get($order, 1, 'ASC'));
		}
		return $query;
	}
}
