<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelHasCurrency extends Model
{
    //

    protected $fillable = [
        'currency_id',
        'model_id',
        'model_type',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
