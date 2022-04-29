<?php
namespace App\Filter;

class typefilter
{
    public function filter($builder, $value)
    {
        return $builder->where('type', $value);
    }

}