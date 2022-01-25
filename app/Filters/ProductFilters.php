<?php

namespace App\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ProductFilters extends QueryFilter
{
    public function search($keyword)
    {
        return $this->builder->where('title', 'like', '%'.$keyword.'%');
    }

    public function price($value)
    {
        return $this->builder->where('price', '<=', $value);
    }

    public function priceOrder($order = 'asc')
    {
        return $this->builder->orderBy('price', $order);
    }

    public function moq($value)
    {
        return $this->builder->where('moq', '<=', $value);
    }

    public function power($value)
    {
        return $this->builder->where('power', '<=', $value);
    }

    public function hashrate($value)
    {
        return $this->builder->where('hashrate', '>=', $value);
    }

    public function country($value)
    {
        return $this->builder->where('country_id', '=', $value);
    }

    public function category($value)
    {
        return $this->builder->whereHas('categories', function (Builder $query) use ($value) {
            $query->where('categories.id', '=', $value);
        });
    }

}