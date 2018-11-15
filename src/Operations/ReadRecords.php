<?php

namespace Isneezy\Celeiro\Operations;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Isneezy\Celeiro\Contracts\IFilterable;
use Isneezy\Celeiro\Filterable\Filterable;
use function Symfony\Component\Debug\Tests\testHeader;

trait ReadRecords {
	/**
	 * @param IFilterable $filterable
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|CrudRepository[]
	 */
	public function findAll(IFilterable $filterable = null) {
		return $this->doQuery(null, $filterable);
	}

	/**
	 * Retrieves a record by its id
	 * If $fail is true, a ModelNotFoundException is throwed
	 *
	 * @param $id
	 * @param IFilterable $filterable
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
	 */
	public function findByID($id, IFilterable $filterable = null) {
		$column = ($this->factory())->getKeyName();
		$query = $this->newQuery();
		$query->where($column, $id);
		return $this->doQuery($query, $filterable, true);
	}

	/**
	 * @param $column string | array
	 * @param $value string | null
	 * @param IFilterable $filterable
	 *
	 * @param bool $first
	 *
	 * @return Model | Collection | LengthAwarePaginator
	 */
	public function findBy($column, $value = null, IFilterable $filterable = null, $first = true) {
		$query = $this->newQuery();
		if (is_array($column)) {
			$query->where($column);
		} else {
			$query->where($column, $value);
		}
		return $this->doQuery($query, $filterable, $first);
	}

	/**
	 * @param $column string | array
	 * @param $value string | null
	 * @param IFilterable $filterable
	 *
	 * @return Collection | LengthAwarePaginator
	 */
	public function findManyBy($column, $value = null, IFilterable $filterable = null) {
		return $this->findBy($column, $value, $filterable, false);
	}
}