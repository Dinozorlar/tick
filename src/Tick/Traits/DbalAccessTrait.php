<?php
namespace Tick\Traits;

trait DbalAccessTrait
{
    /** @var  \Doctrine\DBAL\Connection */
    private $dbal;

    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getDbal()
    {
        return $this->dbal;
    }

    /**
     * @param \Doctrine\DBAL\Connection $dbal
     */
    public function setDbal($dbal)
    {
        $this->dbal = $dbal;
    }
}