<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'agent_id',
        'category',
        'titre',
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

    public function getCategoryLabelAttribute(): string
    {
        return PredefinedService::getCategoryLabels()[$this->category] ?? $this->category ?? 'Autre';
    }
}