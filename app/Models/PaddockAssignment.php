<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaddockAssignment extends Model
{
    public $timestamps = false;

    protected $fillable = ['animal_id', 'paddock_id', 'start_date', 'end_date', 'moved_by'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function paddock()
    {
        return $this->belongsTo(Paddock::class);
    }
}
