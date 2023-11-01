<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    use HasUlids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @return mixed
     */
    public function getTotalMaterialAttribute() : float
    {
        return $this->materials->sum('amount');
    }

    /**
     * @return mixed
     */
    public function getTotalProductionAttribute() : float
    {
        return $this->productions->sum('amount');
    }

    /**
     * @return HasMany
     */
    public function materials() : HasMany
    {
        return $this->hasMany(Material::class);
    }

    /**
     * @return HasMany
     */
    public function productions() : HasMany
    {
        return $this->hasMany(Production::class);
    }
}
