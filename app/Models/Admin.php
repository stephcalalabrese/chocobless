<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table    = 'admins';
    protected $fillable = ['nom','email','mot_de_passe','role','actif','derniere_connexion'];
    protected $hidden   = ['mot_de_passe'];
    protected $casts    = ['actif' => 'boolean', 'derniere_connexion' => 'datetime'];
    public $timestamps  = false;

    public function verifyPassword(string $plain): bool
    {
        return password_verify($plain, $this->mot_de_passe);
    }
    public function isSuperAdmin(): bool { return $this->role === 'super_admin'; }
}
