<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesticide extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function criterias()
    {
        return $this->belongsToMany(Criteria::class, 'pesticide_criterias')->withPivot('description');
    }
}
