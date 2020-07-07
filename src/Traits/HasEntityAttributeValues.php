<?php

namespace DavidWesdijk\LaravelPolymorphicEav\Traits;

trait HasEntityAttributeValues
{
    /**
     * @var string
     */
    static public $relationName = 'polymorphicEntityAttributeValues';

    /**
     * @var string
     */
    static public $attributeName = 'attribute.name';

    /**
     * @var string
     */
    static public $attributeGroup = 'attribute.type';

    /**
     * @var string
     */
    static public $value = 'value';

    /**
     * @return GroupResolver
     */
    public function getPropsAttribute()
    {
        return new GroupResolver($this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function polymorphicEntityAttributeValues()
    {
        return $this->morphMany(EntityAttributeValue::class, 'attributable')->with('attribute');
    }
}
