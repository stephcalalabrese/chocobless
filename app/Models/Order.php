<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model {
    protected $table='orders';
    protected $fillable=['client_id','adresse_id','numero_commande','statut','sous_total','remise','frais_livraison','total','coupon_code','methode_paiement','notes','snap_adresse'];
    const CREATED_AT='cree_le'; const UPDATED_AT='modifie_le';
    const STATUTS=['en_attente'=>['label'=>'En attente','color'=>'yellow'],'confirmee'=>['label'=>'Confirmée','color'=>'blue'],'en_preparation'=>['label'=>'En préparation','color'=>'indigo'],'prete'=>['label'=>'Prête','color'=>'purple'],'en_livraison'=>['label'=>'En livraison','color'=>'orange'],'livree'=>['label'=>'Livrée','color'=>'green'],'annulee'=>['label'=>'Annulée','color'=>'red'],'remboursee'=>['label'=>'Remboursée','color'=>'gray']];
    public function customer(){return $this->belongsTo(Customer::class,'client_id');}
    public function address(){return $this->belongsTo(Address::class,'adresse_id');}
    public function items(){return $this->hasMany(OrderItem::class,'commande_id');}
    public function getStatutLabelAttribute(){return self::STATUTS[$this->statut]['label']??$this->statut;}
    public function getStatutColorAttribute(){return self::STATUTS[$this->statut]['color']??'gray';}
}
