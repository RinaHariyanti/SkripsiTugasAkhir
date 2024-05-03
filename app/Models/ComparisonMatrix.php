<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComparisonMatrix extends Model
{
    use HasFactory;

    protected $fillable = [
        'criteria_name',
        'comparison_data',
        'group_id',
        'eigenvector',
    ];

    protected $casts = [
        'criteria_name' => 'array',
        'comparison_data' => 'array',
    ];
}
