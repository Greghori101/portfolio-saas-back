<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Service extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'services';

    protected $fillable = [
        'portfolio_id',
        'title',
        'description',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
