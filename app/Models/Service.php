<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'agent_id',
        'titre',
        'image',
        'description',
        'points_forts',
        'ordre',
        'actif',
    ];

    protected $casts = [
        'points_forts' => 'array',
        'actif' => 'boolean',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}