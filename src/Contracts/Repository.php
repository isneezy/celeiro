<?php

namespace Isneezy\Celeiro\Contracts;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface Repository {
	/**
	 * @return Builder
	 */
	public function newQuery();

	/**
	 * Creates a model with the $data information
	 * @param array $data
	 * @return Model
	 */
	public function factory(array $data);
}