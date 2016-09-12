<?php

namespace Common;

require_once __DIR__ . '/SampleImmutableDataObject.php';
require_once __DIR__ . '/SampleImmutableDataObjectWithPrivateMembers.php';

class ImmutableObjectTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldHaveReadAccessViaPublicMembersInitialisedByConstructor() {
        $expected = [
            'firstname' => 'hugo',
            'lastname' => 'sobb'
        ];

        $dto = new SampleImmutableDataObject('hugo', 'sobb');

        $this->assertSame('hugo', $dto->firstname);
        $this->assertSame('sobb', $dto->lastname);
        $this->assertSame($expected, $dto->toArray());
    }

    /**
     * @test
     * @expectedException \Exception
     *
     * @todo add custom exception
     */
    public function shouldThrowExceptionOnWriteAccess() {
        $dto = new SampleImmutableDataObject('hugo', 'sobb');
        $dto->lastname = 'anders';
    }

    /**
     * @test
     */
    public function privateMembersShouldStayUntouched() {
        $this->markTestSkipped(
            'TODO: find a solution for trait only modifies public members without reflection'
        );

        $dto = new SampleImmutableImmutableDataObjectWithPrivateMembers('','');
        $dto->updatePrivateMember();

        $this->assertSame('WAS_CHANGED', $dto->getPrivateMemberData());
    }

    /**
     * @test
     */
    public function privateMembersShouldStayPrivate() {
        $dto = new SampleImmutableImmutableDataObjectWithPrivateMembers('','');
        $this->assertSame('INITIAL_STATE', $dto->privateMember, 'This should not be possible');

        $this->markTestIncomplete(
            'This should raise php error, cause of accessing a private member (@see privateMembersShouldStayUntouched)'
        );
    }
}
