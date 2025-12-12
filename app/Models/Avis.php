<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'nom_client',
        'commentaire',
        'note',
        'valide',
    ];

    protected $casts = [
        'valide' => 'boolean',
        'note' => 'integer',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}