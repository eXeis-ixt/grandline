<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marine extends Model
{
    use HasFactory;

    const RANKS = [
        'Fleet Admiral',
        'Admiral',
        'Vice Admiral',
        'Rear Admiral',
        'Commodore',
        'Captain',
        'Commander',
        'Lieutenant Commander',
        'Lieutenant',
        'Warrant Officer',
        'Sergeant Major',
        'Sergeant',
        'Corporal',
        'Seaman First Class',
        'Seaman Apprentice',
        'Seaman Recruit'
    ];

    protected $fillable = [
        'name',
        'rank',
        'bounty',
        'description',
        'sea_id',
        'status',
        'division',
        'specialty'
    ];

    protected $casts = [
        'bounty' => 'integer'
    ];

    public function sea()
    {
        return $this->belongsTo(Sea::class);
    }
}
