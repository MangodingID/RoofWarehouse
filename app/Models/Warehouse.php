<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    use HasUlids;

    const TYPE_WAREHOUSE = 'warehouse';

    const TYPE_BENGKULANGAN = 'bengkulangan';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'type',
    ];

    /**
     * @param  Builder $query
     * @return mixed
     */
    public function scopeWarehouse(Builder $query) : mixed
    {
        return $query->where('type', self::TYPE_WAREHOUSE);
    }

    /**
     * @param  Builder $query
     * @return mixed
     */
    public function scopeBengkulangan(Builder $query) : mixed
    {
        return $query->where('type', self::TYPE_BENGKULANGAN);
    }

    /**
     * @return HasMany
     */
    public function productions() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Production::class);
    }
}
