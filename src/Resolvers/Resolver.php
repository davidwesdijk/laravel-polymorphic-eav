<?php

namespace DavidWesdijk\LaravelPolymorphicEav\Resolvers;

use DavidWesdijk\LaravelPolymorphicEav\EntityAttribute;
use DavidWesdijk\LaravelPolymorphicEav\EntityAttributeValue;
use DavidWesdijk\LaravelPolymorphicEav\Traits\HasEntityAttributeValues;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Collection;

class Resolver implements Arrayable, Jsonable
{
    /**
     * @var GroupResolver
     */
    private $resolver;

    /**
     * @var string
     */
    private $group;

    /**
     * GroupResolver constructor.
     *
     * @param GroupResolver $resolver
     * @param string $group
     */
    public function __construct(GroupResolver $resolver, string $group)
    {
        $this->group = $group;
        $this->resolver = $resolver;
    }

    /**
     * Get the value of the requested property by the called property name
     *
     * @param string $property
     *
     * @return string|null
     */
    public function __get(string $property): ?string
    {
        return $this->getEntityAttributeValue($property)->{HasEntityAttributeValues::$value} ?? null;
    }

    /**
     * Set the value of the requested property by the called property name
     *
     * @param string $property
     * @param string $value
     *
     * @return string|null
     */
    public function __set(string $property, string $value): ?string
    {
        return $this->updateOrCreateValue($property, $value)->{HasEntityAttributeValues::$value};
    }

    /**
     * Unset the entire attribute for the given entity
     *
     * @param string $property
     *
     * @throws \Exception
     */
    public function __unset(string $property): void
    {
        if ($eav = $this->getEntityAttributeValue($property)) {
            $eav->delete();
        }
    }

    /**
     * Implementation of Arrayable contract
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->getProperties()
            ->pluck('value', 'attribute.name')
            ->sort()
            ->toArray();
    }

    /**
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return $this->getProperties()
            ->pluck('value', 'attribute.name')
            ->sort()
            ->toJson($options);
    }

    /**
     * Get all existing properties in the requested group
     *
     * @return Collection
     */
    public function getProperties(): Collection
    {
        return $this->resolver->getProperties($this->group);
    }

    /**
     * @param string $property
     *
     * @return EntityAttributeValue|null
     */
    private function getEntityAttributeValue(string $property): ?EntityAttributeValue
    {
        return $this
            ->getProperties()
            ->firstWhere(HasEntityAttributeValues::$attributeName, $property);
    }

    /**
     * @param string $group
     * @param string $property
     *
     * @return EntityAttribute
     */
    private function getAttribute(string $group, string $property): EntityAttribute
    {
        return EntityAttribute::firstOrCreate([
            'name' => $property,
            'type' => $group,
        ]);
    }

    /**
     * @param string $property
     * @param string $value
     *
     * @return EntityAttributeValue
     */
    private function updateOrCreateValue(string $property, string $value): EntityAttributeValue
    {
        if ($eav = $this->getEntityAttributeValue($property)) {
            $eav->{HasEntityAttributeValues::$value} = $value;
            $eav->save();

        } else {
            $eav = $this
                ->resolver
                ->model
                ->{HasEntityAttributeValues::$relationName}()
                ->create([
                    'entity_attribute_id' => $this->getAttribute($this->group, $property)->getKey(),
                    'value' => $value,
                ]);
        }

        $this->resolver->model->load(HasEntityAttributes::$relationName);

        return $eav;
    }
}
