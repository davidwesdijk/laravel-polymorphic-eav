<?php

namespace DavidWesdijk\LaravelPolymorphicEav\Resolvers;

use DavidWesdijk\LaravelPolymorphicEav\Traits\HasEntityAttributeValues;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class GroupResolver
{
    /**
     * @var Model
     */
    public $model;

    /**
     * Resolver constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param string|null $group
     *
     * @return Collection
     */
    public function getProperties(?string $group = null): Collection
    {
        return $this->model
            ->{HasEntityAttributeValues::$relationName}
            ->when($group, function (Collection $properties) use ($group) {
                return $properties->where(HasEntityAttributeValues::$attributeGroup, $group);
            });
    }

    /**
     * @param string $group
     *
     * @return Resolver
     */
    public function __get(string $group): Resolver
    {
        return new Resolver($this, $group);
    }
}
