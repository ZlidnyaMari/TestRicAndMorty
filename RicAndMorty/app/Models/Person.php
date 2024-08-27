<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';

    /**
     * @property string $name
     * @property string $status
     * @property string $species
     * @property string $gender
     * @property string $image
     * @property string $url
     */
    protected $fillable = [
        'name',
        'status',
        'species',
        'gender',
        'image',
        'url',
    ];

    public function location(): HasOne
    {
        return $this->hasOne(Location::class);
    }

    public function episodes(): BelongsToMany
    {
        return $this->belongsToMany(Episode::class);
    }
}
