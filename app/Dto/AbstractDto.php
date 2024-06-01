<?php

namespace App\Dto;

use Illuminate\Support\Str;

abstract class AbstractDto
{
    protected array $context = [];

    /** @var object|array $args */
    public static function create($args = null): self
    {
        $entity = new static;

        if (!$args) {
            return $entity;
        }

        return $entity->updateFields($args);
    }

    /** @var object|array $args */
    public function updateFields($args = null): self
    {
        if (is_object($args)) {
            $args = get_object_vars($args);
        }

        foreach ($args as $key => $value) {
            if ($this->populateProperty($key, $value)) {
                continue;
            }

            $key = Str::camel($key);;
            $this->populateProperty($key, $value);
        }

        return $this;
    }

    protected function populateProperty(string $property, mixed $value): bool
    {
        if (method_exists($this, 'set' . ucfirst($property))) {
            call_user_func([$this, 'set' . ucfirst($property)], $value);

            return true;
        }

        if (property_exists($this, $property)) {
            $this->$property = $value;

            return true;
        }

        return false;
    }
}