<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Portfolio extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'name',
        'role',
        'specialty',
        'bio',
        'description',
        'settings',
        'is_active',
        'domain',
        'domain_type',
        'theme_id',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    // You may also have:
    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
