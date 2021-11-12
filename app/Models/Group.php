<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mentor()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Returns relationship with Intern Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function intern()
    {
        return $this->hasMany(Intern::class);
    }

    /**
     * Returns relationship with Assignment Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignment()
    {
        return $this->belongsToMany(Assignment::class, 'assignment_groups')
            ->withPivot(
                'start_date',
                'end_date',
                'is_active'
            );
    }

}
