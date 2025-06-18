<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    // Relación: una ficha tiene muchos aprendices
    public function apprentices()
    {
        return $this->hasMany(Apprentice::class);
    }
}
