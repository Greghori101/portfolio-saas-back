<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Skill extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'portfolio_id',
        'name',
        'level',
    ];

    protected $casts = [
        'level' => 'integer',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
