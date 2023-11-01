<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasUlids;

    protected $fillable = [
        'owner_id', 'material', 'product', 'amount', 'note', 'date',
    ];

    /**
     * @return BelongsTo
     */
    public function owner() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }
}
