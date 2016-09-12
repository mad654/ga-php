<?php

namespace Common;


/**
 *
 * Attention: Currently this trait will expose all members as public,
 * because we don't want to use reflection.
 *
 * @see DataObjectTraitTest
 *
 * Defines members of used class as readonly.
 *
 * This works so far but has the drawback, that all
 * private and protected members are effected to and
 * exposed as public.
 *
 * This could easily be solved by reflection, but will cost
 * more performance I think. In the scope of this project
 * we will create a lot of this data objects, which will
 * have no private members.
 *
 * So for now it's ok, but ideas on how to solve this, without
 * reflection are welcome!
 *
 */
trait DataObjectTrait
{

    private $__data = [];

    /**
     * @param array $configData
     * @return static
     */
    public static function fromArray($configData)
    {
        $result = new static();
        $updated = [];

        // save current values for later
        foreach ($configData as $key => $value) {
            if (!property_exists($result, $key)) {
                throw new \InvalidArgumentException("Undefined property: $key");
            }
            $result->__data[$key] = $value;
            array_push($updated, $result);
        }

        // unset all members so magic __set comes into play
        foreach ($result as $property => $value) {
            if ($property == '__data') {
                continue;
            }

            if (!array_key_exists($property, $result->__data)) {
                // Store private, protected values too, so we don't loose
                // any data
                $result->__data[$property] = $value;
            }

            unset($result->$property);
        }

        return $result;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->__data;
    }

    function __get($name)
    {
        return $this->__data[$name];
    }


    function __set($name, $value)
    {
        throw new \Exception("Access violation: readonly property: $name");
    }


}
