<?php

namespace Isneezy\Celeiro\Contracts;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface IRepository {
	/**
	 * @return Builder
	 */
	public function newQuery();
}