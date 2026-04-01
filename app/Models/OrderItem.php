<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class OrderItem extends Model {
    protected $table='order_items';
    protected $fillable=['commande_id','variante_id','nom_produit','label_variante','quantite','prix_unitaire','sous_total'];
    public $timestamps=false;
    public function order(){return $this->belongsTo(Order::class,'commande_id');}
    public function variant(){return $this->belongsTo(ProductVariant::class,'variante_id');}
}
