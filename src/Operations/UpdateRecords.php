<?php

namespace Isneezy\Celeiro\Operations;

use Illuminate\Database\Eloquent\Model;

trait UpdateRecords {
	/**
	 * @param  Model
	 * @return bool
	 */
	public function saveForUpdate($model) {
		return $model->save();
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
	 * @param $model Model
	 * @param $data array
	 */
	protected function setModelData( $model, array $data ) {
		$model->fill( $data );
	}
}