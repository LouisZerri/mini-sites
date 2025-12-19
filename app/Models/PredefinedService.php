<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PredefinedService extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'sort_order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public static function getCategoryLabels(): array
    {
        return [
            'location' => 'Mise en location',
            'gestion' => 'Gestion locative',
            'travaux' => 'Travaux & Maintenance',
            'autres' => 'Autres prestations',
        ];
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::getCategoryLabels()[$this->category] ?? $this->category;
    }

    public static function getActiveByCategory()
    {
        return self::where('active', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');
    }
}