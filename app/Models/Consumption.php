<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumption extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'subscription_id',
        'feature_id',
        'points',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
