<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $table = 'mantenimientos';

    protected $fillable = ['nave_id', 'fecha', 'descripcion', 'coste'];

    use HasFactory;

    // Un mantenimiento pertenece a una nave
    public function nave()
    {
        return $this->belongsTo(Nave::class, 'nave_id');
    }
}
