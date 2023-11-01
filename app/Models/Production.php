<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Production extends Model
{
    use HasUlids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'warehouse_id', 'owner_id', 'amount', 'date', 'note',
    ];

    /**
     * @param  Builder $query
     * @param  Owner   $owner
     * @return Builder
     */
    public function scopeOwn(Builder $query, Owner $owner) : Builder
    {
        return $query->where('owner_id', $owner->getKey());
    }

    /**
     * @param  Builder   $query
     * @param  Warehouse $warehouse
     * @return Builder
     */
    public function scopeSource(Builder $query, Warehouse $warehouse) : Builder
    {
        return $query->where('warehouse_id', $warehouse->getKey());
    }

    /**
     * @param  Builder $query
     * @param  int     $month
     * @param  int     $year
     * @return Builder
     */
    public function scopePeriod(Builder $query, int $month, int $year) : Builder
    {
        return $query->whereMonth('date', $month)->whereYear('date', $year);
    }

    /**
     * @return BelongsTo
     */
    public function warehouse() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * @return BelongsTo
     */
    public function owner() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }
}
