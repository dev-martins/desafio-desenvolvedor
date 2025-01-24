<?php

namespace App\Repositories\Specifications;

use Illuminate\Database\Eloquent\Builder;

class TckrSymbSpecification implements SpecificationInterface
{
    protected $symbol;

    public function __construct(string $symbol)
    {
        $this->symbol = $symbol;
    }

    public function apply(Builder $query): Builder
    {
        return $query->where('TckrSymb', 'like', '%' . $this->symbol . '%');
    }
}
