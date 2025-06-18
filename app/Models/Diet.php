<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    protected $fillable = ['name', 'description'];

    // Relación con animal_diets (si quieres acceder directo a los registros de la tabla intermedia)
    public function animalDiets()
    {
        return $this->hasMany(AnimalDiet::class);
    }

    // Relación many-to-many con animales
    public function animals()
    {
        return $this->belongsToMany(Animal::class, 'animal_diets')
            ->withPivot('start_date', 'end_date', 'notes')
            ->withTimestamps();
    }
    public function diet()
    {
        return $this->belongsTo(Diet::class);
    }
}
