<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    public function airplane(){
        return $this->belongsTo(Airplane::class);
    }

    public function from_city(){
        return $this->belongsTo(City::class);
    }

    public function to_city(){
        return $this->belongsTo(City::class);
    }
}
