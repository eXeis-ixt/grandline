<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Crew extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sea_id',
        'slug'
    ];

    protected $appends = [
        'total_bounty',
        'highest_bounty',
        'members_count'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($crew) {
            if (!$crew->slug) {
                $crew->slug = Str::slug($crew->name);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sea(): BelongsTo
    {
        return $this->belongsTo(Sea::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(CrewMember::class);
    }

    protected function totalBounty(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->members()->sum('bounty')
        );
    }

    protected function highestBounty(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->members()->max('bounty')
        );
    }

    protected function membersCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->members()->count()
        );
    }

    public function scopeWithStats($query)
    {
        return $query->withCount('members')
                    ->withSum('members as total_bounty', 'bounty')
                    ->withMax('members as highest_bounty', 'bounty');
    }

    public function scopeOrderByTotalBounty($query, $direction = 'desc')
    {
        return $query->orderBy('total_bounty', $direction);
    }
} 