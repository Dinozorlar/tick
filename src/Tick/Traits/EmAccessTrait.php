<?php
namespace Tick\Traits;

trait EmAccessTrait
{
    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEm($em)
    {
        $this->em = $em;
    }
}