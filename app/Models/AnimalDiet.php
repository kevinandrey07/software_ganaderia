<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalDiet extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'animal_id', 'diet_id', 'start_date', 'end_date', 'notes'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function diet()
    {
        return $this->belongsTo(Diet::class);
    }
}
