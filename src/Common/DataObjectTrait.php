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

    private $__data_object_trait_data = [];

    /**
     * @param array $configData
     * @return static
     */
    public function freeze()
    {
        // unset all members so magic __set comes into play
        foreach ($this as $property => $value) {
            if ($property == '__data_object_trait_data') {
                continue;
            }

            $this->__data_object_trait_data[$property] = $value;

            unset($this->$property);
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->__data_object_trait_data;
    }

    function __get($name)
    {
        return $this->__data_object_trait_data[$name];
    }


    function __set($name, $value)
    {
        throw new \Exception("Access violation: readonly property: $name");
    }


}
