<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    use HasUlids;

    protected $fillable = [
        'owner_id', 'warehouse_id', 'amount', 'date', 'note',
    ];

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
    public function owner() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * @return BelongsTo
     */
    public function warehouse() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
