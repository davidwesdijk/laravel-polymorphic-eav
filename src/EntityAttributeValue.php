<?php

namespace DavidWesdijk\LaravelPolymorphicEav;

use Illuminate\Database\Eloquent\Model;

class EntityAttributeValue extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'entity_attribute_id',
        'value',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(EntityAttribute::class, 'entity_attribute_id');
    }

    /**
     * @return string|null
     */
    public function getValueAttribute()
    {
        return $this->attributes['value'] ?: $this->getDefault();
    }

    /**
     * Get the default value of an attribute
     *
     * @return null
     */
    private function getDefault()
    {
        return null;
    }
}
