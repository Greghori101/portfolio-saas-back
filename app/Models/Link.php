<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Link extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'links';

    protected $fillable = [
        'portfolio_id',
        'platform',
        'url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
