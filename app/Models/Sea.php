<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sea extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function crews(): HasMany
    {
        return $this->hasMany(Crew::class);
    }
} 