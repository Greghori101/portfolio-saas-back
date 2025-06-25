<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'started_at',
        'expired_at',
        'suppressed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
