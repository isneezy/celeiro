<?php

namespace Isneezy\Celeiro\Operations;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Isneezy\Celeiro\Contracts\IFilterable;

trait ReadRecords {
	/**
	 * @param IFilterable $filterable
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|CrudRepository[]
	 */
	public function findAll(IFilterable $filterable) {
		return $this->doQuery(null, $filterable);
	}

	/**
	 * Retrieves a record by its id
	 * If $fail is true, a ModelNotFoundException is throwed
	 * @param $id
	 * @param bool $fail
	 * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
	 */
	public function findByID($id, $fail = true) {
		$query = $this->newQuery();

		if ($fail) {
			return $query->findOrFail($id);
		}

		return $query->find($id);
	}

	/**
	 * @param $column string | array
	 * @param $value string | null
	 * @param bool $fail
	 *
	 * @return Model
	 */
	public function findBy($column, $value = null, $fail = true) {
		$query = $this->newQuery();
		if (is_array($column)) {
			$query->where($column);
		} else {
			$query->where($column, $value);
		}

		if ($fail) {
			return $query->firstOrFail();
		}
		return $query->first();
	}

	/**
	 * @param $column string | array
	 * @param $value string | null
	 * @param IFilterable $filterable
	 *
	 * @return Collection | LengthAwarePaginator
	 */
	public function findManyBy($column, $value = null, IFilterable $filterable) {
		$query = $this->newQuery();
		if (is_array($column)) {
			$query->where($column);
		} else {
			$query->where($column, $value);
		}
		return $this->doQuery($query, $filterable);
	}
}