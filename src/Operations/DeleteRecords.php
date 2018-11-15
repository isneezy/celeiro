<?php

namespace Isneezy\Celeiro\Operations;


use Isneezy\Celeiro\Contracts\IFilterable;

trait DeleteRecords {
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