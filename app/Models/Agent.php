<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'prenom',
        'nom',
        'slug',
        'email',
        'telephone',
        'photo',
        'bio',
        'accroche',
        'secteur',
        'reseaux_sociaux',
        'actif',
        'titre',
        'langues',
        'disponible',
        'info_legale',
        'parcours',
    ];

    protected $casts = [
        'reseaux_sociaux' => 'array',
        'actif' => 'boolean',
        'disponible' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($agent) {
            if (empty($agent->slug)) {
                $agent->slug = static::generateUniqueSlug($agent->prenom, $agent->nom);
            }
        });
    }

    public static function generateUniqueSlug(string $prenom, string $nom): string
    {
        $slug = Str::slug($prenom . '-' . $nom);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class)->orderBy('ordre');
    }

    public function servicesActifs()
    {
        return $this->hasMany(Service::class)->where('actif', true)->orderBy('ordre');
    }

    public function avisValides()
    {
        return $this->hasMany(Avis::class)->where('valide', true);
    }

    public function getUrlAttribute(): string
    {
        return 'https://' . $this->slug . '.gestimmo-conseillers.fr';
    }

    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function getMoyenneAvisAttribute(): float
    {
        return $this->avisValides()->avg('note') ?? 0;
    }
}
