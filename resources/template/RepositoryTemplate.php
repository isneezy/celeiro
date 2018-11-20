<?php

namespace App\Repositories;
use ReplaceNamespace;

use Isneezy\Celeiro\CrudRepository;

class RepositoryTemplate extends CrudRepository
{
    protected $modelClass = ReplaceModel;
}