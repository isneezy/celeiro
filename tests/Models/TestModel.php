<?php

namespace Isneezy\Celeiro\Tests\Models;


use Illuminate\Database\Eloquent\Model;

class TestModel extends Model {
	protected $table = 'tests';
	public $timestamps = false;
	protected $fillable = ['name'];

	public function test_relation () {
		return $this->hasMany(TestRelationModel::class, 'model_id');
	}
}