<?php

namespace App\Repositories;

use App\Models\Developer;
use App\Repositories\BaseRepository;

class DeveloperRepository extends BaseRepository
{
  protected $modelClass = Developer::class;
}