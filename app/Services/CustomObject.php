<?php

namespace App\Services;

class CustomObject implements \ArrayAccess
{
    public function __construct(
        protected object|array $customItem
    ) {
    }

    /**
     * Retrive an item based on how it has been accessed
     */
    public function __get(string $key): mixed
    {
        if (is_array($this->customItem) || property_exists($this->customItem, $key)) {
            return $this->getItem($key);
        }

        if (method_exists($this->customItem, 'toArray')) {
            $this->customItem = (new self($this->customItem->toArray()))->customItem ?? [];
        } else {
            $this->customItem = (new self((array) $this->customItem))->customItem ?? [];
        }

        return $this->getItem($key);
    }

    /**
     * Get the underlying customItem
     */
    public function get(object|array $customItem = null): \ArrayObject
    {
        return new \ArrayObject(
            $customItem ?? $this->customItem,
            \ArrayObject::ARRAY_AS_PROPS | \ArrayObject::STD_PROP_LIST
        );
    }

    /**
     * Get the underlying customItem as an array
     */
    public function toArray(): array
    {
        return $this->get()->getArrayCopy();
    }

    /**
     * Get an item from the customItem property
     */
    public function getItem(string $key): mixed
    {
        /**
         * If an array was supplied, access it as an array
         */
        if (is_array($this->customItem)) {
            if (isset($this->customItem[$key])) {
                if (is_array($this->customItem[$key])) {
                    return new self($this->customItem[$key]);
                }

                return $this->customItem[$key];
            }
        }

        /**
         * If an object was supplied, access it as an object
         */
        if (is_object($this->customItem) && property_exists($this->customItem, $key)) {
            if (is_array($this->customItem->{$key}) || is_object($this->customItem->{$key})) {
                return new self($this->customItem->{$key});
            }

            return $this->customItem->{$key};
        }

        return null;
    }

    public function offsetExists($offset): bool
    {
        if (is_object($this->customItem)) {
            return property_exists($this->customItem, $offset);
        }

        return isset($this->customItem[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        if (is_object($this->customItem)) {
            return $this->customItem->{$offset};
        }

        return $this->customItem[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        if (is_object($this->customItem)) {
            $this->customItem->{$offset} = $value;

            return;
        }

        $this->customItem[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        if (is_object($this->customItem)) {
            unset($this->customItem->{$offset});

            return;
        }

        unset($this->customItem[$offset]);
    }
}
