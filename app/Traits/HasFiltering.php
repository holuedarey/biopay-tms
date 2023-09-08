<?php

/**
 * @author Lyte Onyema
 * @link https://github.com/teqbylyte
 */

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait HasFiltering
{
    public function scopeFilter(Builder $query, array $filter)
    {
        $query->when($filter['service'] ?? false, function ($query, $service) {
            $query->whereHas('service', function ($query) use ($service) {
                $query->where('name', $service);
            });
        });

        $query->when($filter['email'] ?? false, function ($query, $email) {
            $query->whereHas('agent', function ($query) use ($email) {
                $query->where('email', $email);
            });
        });

        $query->when($filter['status'] ?? false, function ($query, $status) {
            $query->where('status', $status);
        });
    }


    /**
     * Filter the transactions by the date description:
     *
     * <p>`today` - Transactions for just today,
     * <p>`week` - This week's transactions,
     * <p>`month` - This month's transactions,
     * <p>`year` - This year's transactions.
     *
     * @param Builder $query
     * @param string|null $description
     * @param string $column
     * @return void
     */
    public function scopeFilterByDateDesc(Builder $query, ?string $description = '', string $column = 'created_at'): void
    {
        $query->when($description == 'today',
            fn($query) => $query->today($column)
        )->when($description == 'yesterday',
            fn($query) => $query->whereDate($column, today()->subDay())
        )->when($description == 'week',
            fn(Builder $query) => $query->whereBetween($column, [today()->startOfWeek(), today()])
        )->when($description == 'month',
            fn($query) => $query->whereMonth($column, today()->month)->whereYear($column, today()->year)
        )->when($description == 'year',
            fn($query) => $query->whereYear($column, today()->year)
        );
    }

    /**
     * Filter the transactions by specific date or the date range (which is given as an array).
     *
     * @param Builder $query
     * @param array|null $date
     * @return void
     */
    public function scopeFilterByDate(Builder $query, ?array $date = null): void
    {
        if (!empty($date)) {
            $query->when(count($date) == 2,
                fn($query) => $query->whereBetween(DB::raw('DATE(created_at)'), $date)
            )->when(count($date) == 1,
                fn($query) => $query->whereDate('created_at', $date[0])
            );
        }
    }

    public function scopeToday(Builder $builder, string $column = 'created_at'): void
    {
        $builder->whereDate($column, today());
    }
}
