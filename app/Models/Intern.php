<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'city',
        'address',
        'email',
        'phone',
        'cv',
        'github',
        'group_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Returns relationship with Group Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        $this->belongsTo(Group::class);
    }

    /**
     * Returns relationship with Review Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function review()
    {
        $this->hasMany(Review::class);
    }

}