<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrewMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'bounty',
        'crew_id',
    ];

    protected $casts = [
        'bounty' => 'integer'
    ];

    public function crew(): BelongsTo
    {
        return $this->belongsTo(Crew::class);
    }
} 