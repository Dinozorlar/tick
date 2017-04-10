<?php

namespace Tick;

use Saxulum\DoctrineOrmManagerRegistry\Doctrine\ManagerRegistry;

class Application extends \Silex\Application
{
    /**
     * @return ManagerRegistry
     */
    public function getDoctrine()
    {
        return $this['doctrine'];
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this['twig'];
    }
}
