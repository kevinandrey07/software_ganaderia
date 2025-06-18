<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalStatus extends Model
{
    protected $fillable = ['name', 'description'];

    public function animals()
    {
        return $this->hasMany(Animal::class, 'status_id');
    }

    public function oldChanges()
    {
        return $this->hasMany(AnimalStatusChange::class, 'old_status_id');
    }

    public function newChanges()
    {
        return $this->hasMany(AnimalStatusChange::class, 'new_status_id');
    }
}
