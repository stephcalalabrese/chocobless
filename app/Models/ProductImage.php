<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProductImage extends Model {
    protected $table='product_images';
    protected $fillable=['produit_id','url_image','alt_text','ordre'];
    public $timestamps=false;
}
