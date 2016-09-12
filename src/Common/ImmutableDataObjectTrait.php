<?php

namespace Common;


/**
 *
 * Attention: Currently this trait will expose all members as public,
 * because we don't want to use reflection.
 *
 * Defines members of used class as readonly.
 *
 * usage:
 *
 * <code>
 *
 * class PersonDto {
 *   use ImmutableDataObjectTrait;
 *
 *   public name = 'UNKNOWN';
 *
 *   public function __construct($name) {
 *     $this->name = $name;
 *     $this->freeze;
 *   }
 * }
 *
 * $max = new PersonDto('Max Mustermann');
 * echo $max->name; // Max Mustermann
 * $max->name = 'Erwin Anders' // throws Exception
 *
 * </code>
 *
 * @see ImmutableDataObjectTraitTest
 *
 * This works so far but has the drawback, that all
 * private and protected members are exposed as public, too.
 *
 * This could easily be solved by reflection, but will cost
 * more performance, I think. In the scope of this project
 * we will create a lot of this data objects, which will
 * have no private members.
 *
 * So for now it's ok, but ideas on how to solve this, without
 * reflection are welcome!
 *
 */
trait ImmutableDataObjectTrait
{

    private $__immutable_data_object_trait_data = [];

    /**
     * ImmutableDataObjectTrait constructor.
     */
    public function __construct()
    {
        // avoid accidentally usage as normal, writable object
        $this->freeze();
    }


    /**
     * @param array $configData
     * @return static
     */
    public function freeze()
    {
        // unset all members so magic __set comes into play
        foreach ($this as $property => $value) {
            if ($property == '__immutable_data_object_trait_data') {
                continue;
            }

            $this->__immutable_data_object_trait_data[$property] = $value;

            unset($this->$property);
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->__immutable_data_object_trait_data;
    }

    function __get($name)
    {
        return $this->__immutable_data_object_trait_data[$name];
    }


    function __set($name, $value)
    {
        throw new \Exception("Access violation: readonly property: $name");
    }


}
