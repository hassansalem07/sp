<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosOrder extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function order_products()
    {
        return $this->hasMany(PosOrderProduct::class, 'pos_order_id', 'id');
    }
}
