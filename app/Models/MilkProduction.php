<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MilkProduction extends Model
{
    public $timestamps = false;

    protected $fillable = ['animal_id', 'date', 'liters', 'notes'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}

