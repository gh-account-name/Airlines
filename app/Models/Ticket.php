<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public $fillable = ['status']; //Прост чтобы на update не руглася 

    use HasFactory;
}
