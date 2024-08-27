<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Episode extends Model
{
    use HasFactory;

    /**
     * @property string $episode
     */
    protected $fillable = [
        'url',
        'episode',
    ];

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }
}
