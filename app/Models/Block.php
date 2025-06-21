<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Block extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'portfolio_id',
        'type',
        'content',
        'section',
        'position',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'position' => 'integer',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
