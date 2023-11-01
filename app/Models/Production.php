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
