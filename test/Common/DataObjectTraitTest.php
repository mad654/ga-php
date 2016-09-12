<?php
/**
 * Created by PhpStorm.
 * User: mann
 * Date: 12.09.16
 * Time: 20:46
 */

namespace Common;

require_once __DIR__ . '/SampleDataObject.php';
require_once __DIR__ . '/SampleDataObjectWithPrivateMembers.php';

class DataObjectTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldHaveReadAccessViaPublicMembers() {
        $expected = [
            'firstname' => 'hugo',
            'lastname' => 'sobb'
        ];

        $dto = SampleDataObject::fromArray($expected);

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
        $dto = SampleDataObject::fromArray([
            'firstname' => 'hugo',
            'lastname' => 'sobb'
        ]);

        $dto->lastname = 'anders';
    }

    /**
     * @test
     */
    public function privateMembersShouldStayUntouched() {
        $this->markTestSkipped(
            'TODO: find a solution for trait only modifies public members without reflection'
        );

        $dto = SampleDataObjectWithPrivateMembers::fromArray([]);
        $dto->updatePrivateMember();

        $this->assertSame('WAS_CHANGED', $dto->getPrivateMemberData());
    }

    /**
     * @test
     */
    public function privateMembersShouldStayPrivate() {
        $dto = SampleDataObjectWithPrivateMembers::fromArray([]);
        $this->assertSame('INITIAL_STATE', $dto->privateMember, 'This should not be possible');

        $this->markTestIncomplete(
            'This should raise php error, cause of accessing a private member (@see privateMembersShouldStayUntouched)'
        );
    }
}
