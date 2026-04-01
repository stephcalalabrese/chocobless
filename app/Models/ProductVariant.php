<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProductVariant extends Model {
    protected $table='product_variants';
    protected $fillable=['produit_id','label','sku','prix','prix_promo','stock','actif'];
    protected $casts=['actif'=>'boolean','prix'=>'float','prix_promo'=>'float'];
    public $timestamps=false;
    public function product(){return $this->belongsTo(Product::class,'produit_id');}
}
