<?php

namespace App\Models;

use App\Models\Enums\ReviewData;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @return HasMany
     */
    public function assignment(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Returns relationship with Mentor Model
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
}
