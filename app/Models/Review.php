<?php

namespace App\Models;

use App\Models\Enums\ReviewData;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model implements ReviewData
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'pros',
        'cons',
        'mark',
        'assignment_id',
        'mentor_id',
        'intern_id',

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
     * Prepare a date for array / JSON serialization
     *
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h-m-s');
    }

    /**
     * Returns relationship with Assignment Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assignment()
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Returns relationship with Mentor Model
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
}
