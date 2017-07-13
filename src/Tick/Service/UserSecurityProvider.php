<?php

namespace Tick\Service;

use Doctrine\ORM\Query;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Tick\Model\UserSecurityUser;
use Tick\Traits\EmAccessTrait;

class UserSecurityProvider implements UserProviderInterface
{
    use EmAccessTrait;

    public function loadUserByUsername($username)
    {


        $user = $this->loadUserFromDB($username);
        if ($user) {

            $roles = ['USER_ROLE'];

            $uClass = new UserSecurityUser($user['username'], $user['password'],$roles);

            $uClass->setSalt($user['salt']);
            $uClass->setFullName($user['fullname']);
            $uClass->setUserID($user['id']);

            return $uClass;
        }

        throw new UsernameNotFoundException('Yok ');
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user);
    }

    public function supportsClass($class)
    {
        return $class === 'Tick\Model\UserSecurityUser';
    }

    public function loadUserFromDB($username)
    {
        $em = $this->getEm();

        return $em->createQuery('select user from Tick:User user where user.username=:username')
            ->setParameter('username', $username)
            ->getOneOrNullResult(Query::HYDRATE_ARRAY);

    }


}