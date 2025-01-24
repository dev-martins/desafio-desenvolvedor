<?php 

namespace App\Repositories\Specifications;

use Illuminate\Database\Eloquent\Builder;

interface SpecificationInterface
{
    public function apply(Builder $query): Builder;
}
