<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasUlids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'amount', 'price', 'date', 'warehouse_id',
    ];

    /**
     * @return float
     */
    public function getTotalAttribute() : float
    {
        return $this->amount * $this->price;
    }

    /**
     * @return BelongsTo
     */
    public function warehouse() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
