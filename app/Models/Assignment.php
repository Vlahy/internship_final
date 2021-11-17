<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot',
    ];

    /**
     * Returns relationship with Group Model
     *
     * @return BelongsToMany
     */
    public function group(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'assignment_groups');
    }

    /**
     * Returns relationship with Review Model
     *
     * @return HasMany
     */
    public function review(): HasMany
    {
        return $this->hasMany(Review::class, 'assignment_id');
    }
}
