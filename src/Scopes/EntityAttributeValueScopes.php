<?php

namespace DavidWesdijk\LaravelPolymorphicEav\Scopes;

use DavidWesdijk\LaravelPolymorphicEav\EntityAttribute;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait EntityAttributeValueScopes
 * @package DavidWesdijk\LaravelPolymorphicEav\Scopes
 *
 * @method static hasAttribute(EntityAttribute|int $attribute) Get instances with a given attribute
 */
trait EntityAttributeValueScopes
{
    /**
     * Get instances with a given attribute
     *
     * @param Builder $query
     * @param $attribute
     *
     * @return Builder
     */
    public function scopeHasAttribute(Builder $query, $attribute): Builder
    {
        $attributeId = ($attribute instanceof EntityAttribute) ? $attribute->id : $attribute;

        return $query->whereHas(static::$relationName, function (Builder $query) use ($attributeId) {
            $query->where('entity_attribute_id', $attributeId);
        });
    }
}
