<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $table = 'products';

    protected $fillable = [
        'categorie_id',
        'nom',
        'slug',
        'description_courte',
        'description',
        'image_principale',
        'actif',
        'en_vedette',
    ];

    protected $casts = [
        'actif'      => 'boolean',
        'en_vedette' => 'boolean',
    ];

    // ── Relations ───────────────────────────────────────────
    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'produit_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'produit_id')->orderBy('ordre');
    }

    public function ocasiones()
    {
        return $this->belongsToMany(Ocasion::class, 'ocasion_product', 'product_id', 'ocasion_id');
    }

    // ── Accessors ───────────────────────────────────────────
    public function getPrixMinAttribute()
    {
        return $this->variants()->where('actif', 1)->min('prix');
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
