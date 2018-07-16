<?php

namespace Isneezy\Celeiro;

use Isneezy\Celeiro\Operations\CreateRecords;
use Isneezy\Celeiro\Operations\DeleteRecords;
use Isneezy\Celeiro\Operations\ReadRecords;
use Isneezy\Celeiro\Operations\UpdateRecords;

abstract class CrudRepository extends Repository {
	use ReadRecords, CreateRecords, DeleteRecords, UpdateRecords;
}