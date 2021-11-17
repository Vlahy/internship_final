<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Returns relationship with User Model
     *
     * @return HasMany
     */
    public function mentor(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Returns relationship with Intern Model
     *
     * @return HasMany
     */
    public function intern(): HasMany
    {
        return $this->hasMany(Intern::class);
    }

    /**
     * Returns relationship with Assignment Model
     *
     * @return BelongsToMany
     */
    public function assignment(): BelongsToMany
    {
        return $this->belongsToMany(Assignment::class, 'assignment_groups')
            ->withPivot(
                'start_date',
                'end_date',
                'is_active'
            );
    }

}
