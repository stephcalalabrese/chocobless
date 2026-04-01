<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Address extends Model {
    protected $table='addresses';
    protected $fillable=['client_id','etiquette','prenom','nom','rue','complemento','barrio','ciudad','departamento','codigo_postal','pais','telefono','por_defecto'];
    protected $casts=['por_defecto'=>'boolean']; public $timestamps=false;
}
