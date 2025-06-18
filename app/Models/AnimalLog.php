<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['animal_id', 'type', 'description', 'created_at'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
