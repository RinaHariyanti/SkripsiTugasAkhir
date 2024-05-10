<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComparisonAlternatif extends Model
{
    use HasFactory;

    protected $fillable = [
        'criteria_name',
        'comparison_data',
        'criteria_id',
        'group_id',
        'eigenvector',
        'user_id',
    ];

    protected $casts = [
        'criteria_name' => 'array',
        'comparison_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
