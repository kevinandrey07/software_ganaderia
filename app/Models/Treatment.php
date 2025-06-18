<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    public $timestamps = false;

    protected $fillable = ['incident_id', 'description', 'treated_by', 'date'];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
