<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    use HasFactory;

    /**
     * @property int $person_id
     * @property string $name
     * @property string $url
     */
    protected $fillable = [
        'person_id',
        'name',
        'url',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
