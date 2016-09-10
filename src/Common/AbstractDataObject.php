<?php


namespace Common;


abstract class AbstractDataObject implements ArrayAble
{
    /**
     * @param array $configData
     * @return static
     */
    public static function fromArray($configData)
    {
        $result = new static();

        foreach ($configData as $key => $value) {
            if (!property_exists($result, $key)) {
                throw new \InvalidArgumentException("Undefined property: $key");
            }

            $result->$key = $value;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];

        foreach ($this as $key => $value) {
            $result[$key] = $value;
        }

        return $result;
    }
}
