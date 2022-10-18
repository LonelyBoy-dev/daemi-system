<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factor_row extends Model
{
    use HasFactory;
    protected $table='factor_row';
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
