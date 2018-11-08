<?php

namespace Isneezy\Celeiro\Tests;


use Illuminate\Database\Eloquent\Model;

class TestModel extends Model {
	protected $table = 'tests';
	public $timestamps = false;
	protected $fillable = ['name'];
}