<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    public $timestamps = false;

    protected $fillable = ['animal_id', 'vaccine_name', 'reason', 'applied_by', 'date'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
