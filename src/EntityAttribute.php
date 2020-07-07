<?php

namespace DavidWesdijk\LaravelPolymorphicEav;

use Illuminate\Database\Eloquent\Model;

class EntityAttribute extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany(EntityAttributeValue::class);
    }
}
