<?php


namespace Common;


class SampleImmutableImmutableDataObjectWithPrivateMembers extends SampleImmutableDataObject
{
    use ImmutableDataObjectTrait;

    private $privateMember = 'INITIAL_STATE';

    /**
     * @param string $privateMember
     */
    public function updatePrivateMember()
    {
        $this->privateMember = 'WAS_CHANGED';
    }

    /**
     * @return string
     */
    public function getPrivateMember()
    {
        return $this->privateMember;
    }


}
