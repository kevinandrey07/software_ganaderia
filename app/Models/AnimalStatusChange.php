<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalStatusChange extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'animal_id', 'old_status_id', 'new_status_id', 'changed_at', 'changed_by'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function oldStatus()
    {
        return $this->belongsTo(AnimalStatus::class, 'old_status_id');
    }

    public function newStatus()
    {
        return $this->belongsTo(AnimalStatus::class, 'new_status_id');
    }
}
