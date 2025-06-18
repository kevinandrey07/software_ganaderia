<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    public $timestamps = false;

    protected $fillable = ['animal_id', 'type', 'description', 'reported_by', 'date'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }
}

