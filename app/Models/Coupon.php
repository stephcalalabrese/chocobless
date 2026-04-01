<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Coupon extends Model {
    protected $table='coupons';
    protected $fillable=['code','type_remise','valeur','montant_minimum','utilisations_max','date_expiration','actif'];
    protected $casts=['actif'=>'boolean','date_expiration'=>'date','valeur'=>'float'];
    public $timestamps=false;
    public function isValid():bool {
        if(!$this->actif)return false;
        if($this->date_expiration&&$this->date_expiration->isPast())return false;
        if($this->utilisations_max&&$this->utilisations_actuelles>=$this->utilisations_max)return false;
        return true;
    }
}
