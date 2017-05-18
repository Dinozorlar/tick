<?php
namespace Tick\Traits;

trait RandomGeneratorTrait
{
    /**
     * @var \Tick\Service\RandomGenerator
     */
    private $randomGenerator;

    /**
     * @return \Tick\Service\RandomGenerator
     */
    public function getRandomGenerator()
    {
        return $this->randomGenerator;
    }

    /**
     * @param \Tick\Service\RandomGenerator $randomGenerator
     */
    public function setRandomGenerator($randomGenerator)
    {
        $this->randomGenerator = $randomGenerator;
    }
}