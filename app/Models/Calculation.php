<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    protected $guarded = [];

    public function greenAreaRate()
    {
        return $this->belongsTo(GreenAreaRate::class);
    }

    public function items()
    {
        return $this->hasMany(CalculationItem::class);
    }
}