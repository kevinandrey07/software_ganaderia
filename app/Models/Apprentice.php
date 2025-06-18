<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apprentice extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_date',
        'gender',
        'training_record_id',
        'stage',
    ];

    // Relación: un aprendiz pertenece a una ficha
    public function trainingRecord()
    {
        return $this->belongsTo(TrainingRecord::class);
    }

    // Relación: un aprendiz tiene muchas tareas
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
