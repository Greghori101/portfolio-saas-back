<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'status',
        'type',
    ];

    public function currency()
    {
        return $this->morphToMany(Currency::class, 'model', 'mode_has_currencies')->first();
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'plan_feature')->withPivot(['points', 'consumable']);
    }
}
