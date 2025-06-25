<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'slug',
        'name',
        'type',
    ];

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_feature')->withPivot(['points', 'consumable']);
    }
}
