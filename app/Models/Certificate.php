<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Certificate extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'certificates';

    protected $fillable = [
        'portfolio_id',
        'title',
        'issuer',
        'issued_at',
        'expires_at',
        'certificate_url',
    ];

    protected $casts = [
        'issued_at' => 'date',
        'expires_at' => 'date',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
