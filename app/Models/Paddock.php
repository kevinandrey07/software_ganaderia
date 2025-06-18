<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paddock extends Model
{
    protected $fillable = ['name', 'location', 'description'];

    public function assignments()
    {
        return $this->hasMany(PaddockAssignment::class);
    }
}
