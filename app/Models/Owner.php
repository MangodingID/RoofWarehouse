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
     * @return HasMany
     */
    public function productions() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Production::class);
    }
}
