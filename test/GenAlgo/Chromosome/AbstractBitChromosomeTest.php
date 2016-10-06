<?php


namespace GenAlgo\Chromosome;

require_once __DIR__ . '/DummyChromosome.php';

use Common\RandomNumberGenerator;
use GenAlgo\Chromosome;
use PHPUnit\Framework\TestCase;

class AbstractBitChromosomeTest extends TestCase
{
    private $randomNumberGenerator;

    protected function setUp()
    {
        parent::setUp();
        $this->randomNumberGenerator = $this->createMock(RandomNumberGenerator::class);
    }

    /**
     * @test
     */
    public function shouldImplementChromosomeInterface() {
        $sut = $this->c('');
        $this->assertInstanceOf(Chromosome::class, $sut);
        $this->assertInstanceOf(AbstractBitChromosome::class, $sut);
    }

    /**
     * @test
     */
    public function shouldCrossover() {
        $this->rand(0); $this->assert(['0','0'], $this->c('0')->crossover($this->c('0')));
        $this->rand(1); $this->assert(['0','0'], $this->c('0')->crossover($this->c('0')));
        $this->rand(1); $this->assert(['11', '00'], $this->c('10')->crossover($this->c('01')));
        $this->rand(1); $this->assert(['10', '01'], $this->c('11')->crossover($this->c('00')));

        $this->rand(0); $this->assert(['00', '11'], $this->c('11')->crossover($this->c('00')));
        $this->rand(1); $this->assert(['10', '01'], $this->c('11')->crossover($this->c('00')));
        $this->rand(2); $this->assert(['11', '00'], $this->c('11')->crossover($this->c('00')));

        $this->rand(0); $this->assert(['001', '110'], $this->c('110')->crossover($this->c('001')));
        $this->rand(1); $this->assert(['101', '010'], $this->c('110')->crossover($this->c('001')));
        $this->rand(2); $this->assert(['111', '000'], $this->c('110')->crossover($this->c('001')));
        $this->rand(3); $this->assert(['110', '001'], $this->c('110')->crossover($this->c('001')));
    }

    /**
     * @return DummyChromosome
     */
    private function c($code)
    {
        $chromosome = new DummyChromosome($code, $this->randomNumberGenerator);
        return $chromosome;
    }

    /**
     * @param array $expectedCodes
     * @param array $actual
     */
    private function assert($expectedCodes, $actual)
    {
        $expected = [];

        foreach ($expectedCodes as $code) {
            $expected[] = $this->c($code);
        }

        $this->assertEquals($expected, $actual);
    }

    private function rand($int)
    {
        $this->randomNumberGenerator = $this->createMock(RandomNumberGenerator::class);
        $this->randomNumberGenerator->method('get')->willReturn($int);
    }

}
