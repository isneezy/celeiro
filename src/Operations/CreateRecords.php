<?php

namespace Isneezy\Celeiro\Operations;

use Illuminate\Database\Eloquent\Model;

trait CreateRecords {
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
	 * @param array $data
	 * @return Model
	 */
	public function create (array $data) {
		$model = $this->factory($data);
		$this->save($model);
		return $model;
	}
}