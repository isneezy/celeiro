<?php

namespace Isneezy\Celeiro;


use Illuminate\Database\Eloquent\Model;
use Isneezy\Celeiro\Contracts\Filterable;

abstract class CrudRepository extends Repository {

	/**
	 * Performs the save method of the model
	 * The goal is to enable the implementation of our business logic before the command.
	 * @param Model
	 *
	 * @return bool
	 */
	public function save($model) {
		return $model->save();
	}

	/**
	 * @param  Model
	 * @return bool
	 */
	public function saveForUpdate($model) {
		return $model->save();
	}

	/**
	 * @param array $data
	 * @return Model
	 */
	public function create (array $data) {
		$model = $this->factory($data);
		$this->save($model);
		return $model;
	}

	/**
	 * Updates model information using $data
	 *
	 * @param  Model | \Illuminate\Database\Eloquent\Model $model
	 * @param array $data
	 * @return boolean
	 */
	public function update($model, array $data = []) {
		$data = array_merge($model->toArray(), $data);
		$this->setModelData($model, $data);
		return $this->saveForUpdate($model);
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

	/**
	 * @param Filterable $filterable
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|CrudRepository[]
	 */
	public function findAll(Filterable $filterable) {
		return $this->doQuery(null, $filterable);
	}

	/**
	 * Performs the delete command model
	 * The goal is to enable the implementation of our business logic before the command.
	 * @param int $id
	 * @return bool
	 */
	public function delete($id){
		$model = $this->findByID($id);
		return $model->delete();
	}

}