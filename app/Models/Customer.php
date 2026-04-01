<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Customer extends Model {
    protected $table='customers';
    protected $fillable=['prenom','nom','email','telephone','mot_de_passe','actif'];
    protected $hidden=['mot_de_passe']; protected $casts=['actif'=>'boolean'];
    const CREATED_AT='cree_le'; const UPDATED_AT=null;
    public function orders(){return $this->hasMany(Order::class,'client_id');}
    public function addresses(){return $this->hasMany(Address::class,'client_id');}
    public function getFullNameAttribute(){return trim("{$this->prenom} {$this->nom}");}
}
