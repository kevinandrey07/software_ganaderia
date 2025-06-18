<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $fillable = [
        'code', 'name', 'sex', 'birth_date', 'breed_id', 'status_id'
    ];

    // Relación con raza
    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    // Relación con estado
    public function status()
    {
        return $this->belongsTo(AnimalStatus::class, 'status_id');
    }

    // Dietas (many-to-many con pivote)
    public function diets()
{
    return $this->belongsToMany(Diet::class, 'animal_diets')
        ->withPivot('start_date', 'end_date', 'notes');
}




    // Logs de seguimiento
    public function logs()
    {
        return $this->hasMany(AnimalLog::class);
    }

    // Producción de leche
    public function milkProductions()
    {
        return $this->hasMany(MilkProduction::class);
    }

    // Accidentes / enfermedades
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    // Vacunas
    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }

    // Asignaciones de potreros
    public function paddockAssignments()
    {
        return $this->hasMany(PaddockAssignment::class);
    }

    // Cambios de estado
    public function statusChanges()
    {
        return $this->hasMany(AnimalStatusChange::class);
    }
}
