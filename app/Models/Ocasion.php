<?php
// app/Models/Ocasion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ocasion extends Model
{
    public $timestamps = false;

    protected $table = 'ocasiones';

    protected $fillable = [
        'nom',
        'slug',
        'descripcion',
        'icono',
        'color',
        'ordre',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    // ── Scopes ──────────────────────────────────────────────
    public function scopeActif($query)
    {
        return $query->where('actif', 1)->orderBy('ordre');
    }

    // ── Relations ───────────────────────────────────────────
    public function products()
    {
        return $this->belongsToMany(Product::class, 'ocasion_product', 'ocasion_id', 'product_id');
    }

    // ── Boot ────────────────────────────────────────────────
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($m) {
            if (empty($m->slug)) {
                $m->slug = Str::slug($m->nom);
            }
        });
    }
}
