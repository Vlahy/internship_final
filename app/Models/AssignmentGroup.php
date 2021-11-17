<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssignmentGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'assignment_id',
        'group_id',
        'start_date',
        'end_date',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Returns relationship with Assignment Model
     *
     * @return HasMany
     */
    public function assignment(): HasMany
    {
        return $this->hasMany(AssignmentGroup::class);
    }

    /**
     * Returns relationship with Group Model
     *
     * @return HasMany
     */
    public function group(): HasMany
    {
        return $this->hasMany(Group::class);
    }
}
