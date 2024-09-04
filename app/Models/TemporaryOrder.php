<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemporaryOrder extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'table_number', 'customer_name', 'product_id', 'quantity'];

    /**
     * Get the product that owns the TemporaryOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
