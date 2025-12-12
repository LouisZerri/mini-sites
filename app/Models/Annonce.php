<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'titre',
        'description',
        'prix',
        'type',
        'photos',
        'visible',
    ];

    protected $casts = [
        'photos' => 'array',
        'visible' => 'boolean',
        'prix' => 'decimal:2',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}