<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesticideCriteria extends Model
{
    use HasFactory;

    protected $table = 'pesticide_criterias';

    protected $fillable = [
        'pesticide_id',
        'criteria_id',
        'description',
    ];

    public function pesticide()
    {
        return $this->belongsTo(Pesticide::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
