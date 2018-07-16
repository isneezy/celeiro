<?php

namespace Isneezy\Celeiro\Operations;

use Isneezy\Celeiro\Contracts\Filterable;

trait ReadRecords {
	/**
	 * @param Filterable $filterable
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|CrudRepository[]
	 */
	public function findAll(Filterable $filterable) {
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
			$query->findOrFail($id);
		}

		return $query->find($id);
	}
}