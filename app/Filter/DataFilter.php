<?php

namespace App\Filter;
use App\Filter\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class DataFilter extends AbstractFilter
{
    protected $filters = [
        'type' => typefilter::class
    ];
}