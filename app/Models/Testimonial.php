<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Testimonial extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'portfolio_id',
        'author',
        'quote',
        'position',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
