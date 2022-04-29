<?php

namespace App\Filter;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquesnt\Builder;

abstract class AbstractFilter
{
    protected $request;

    protected $filters = [];

    public function __contruct(Request $request)
    {
        $this->request = $request;
    }

    public function filter(Builder $builder)
    {   
        foreach($this->getFilters() as $filter => $value)
        {
            $this->resolveFilter($filter)->filter($builder, $value);
        }
        return $builder;
    }

    protected function getFilters()
    {
        return array_filter($this->request->only(array_keys($this->filters)));
    }

    protected function resolveFilter($filter)
    {
        return new $this->filters[$filter];
    }
}