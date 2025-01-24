<?php

namespace App\Repositories\Specifications;

use Illuminate\Database\Eloquent\Builder;

class RptDtSpecification implements SpecificationInterface
{
    protected $date;

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function apply(Builder $query): Builder
    {
        return $query->whereDate('RptDt', $this->date);
    }
}
