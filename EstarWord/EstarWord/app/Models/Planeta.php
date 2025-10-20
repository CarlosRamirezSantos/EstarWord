<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Planeta extends Model
{     

  protected $fillable = ['nombre', 'periodo_rotacion', 'poblacion', 'clima'];

  use HasFactory;
    public function naves()
    {
        return $this->hasMany(Nave::class, 'planeta_id', 'id');
    }


    

}