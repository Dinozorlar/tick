<?php
namespace Tick\ConsoleCommands;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Tick\Traits\DbalAccessTrait;
use Tick\Traits\EmAccessTrait;
use Tick\Traits\RandomGeneratorTrait;

class CreateDefaultUsers extends Command
{
    use RandomGeneratorTrait;
    use DbalAccessTrait;
    use EmAccessTrait;

    /** @var \Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder */
    private $passwordEncoder;

    /**
     * @return \Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder
     */
    public function getPasswordEncoder()
    {
        return $this->passwordEncoder;
    }

    /**
     * @param \Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder $passwordEncoder
     */
    public function setPasswordEncoder($passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function configure()
    {
        $this
            ->setName('tick:system:create-default-users')
            ->setDescription('Default userlari olusturur')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $users = [
            [
                'username' => 'cankat',
                'password' => '123456',
                'name' => 'Cankat',
                'lastName' => 'Akdemir',
                'fullname' => 'Cankat Akdemir',
                'email' => 'cankat@cankat.com'
            ],
            [
                'username' => 'ali',
                'password' => 'abc',
                'name' => 'Ali',
                'lastName' => 'Gündoğdu',
                'fullname' => 'Ali Gündoğdu',
                'email' => 'ali@ali.com'
            ]
        ];

        foreach ($users as $user) {
            $existing = $this->dbal->fetchAssoc(
                'select id from users where username = :username',
                ['username' => $user['username']]
            );

            if ($existing) {
                $io->warning("{$user['username']} zaten var");
                continue;
            }

            $userEntity = new \Tick\Entity\User();
            $userEntity->setUsername($user['username']);
            $userEntity->setSalt($this->randomGenerator->generate());
            $userEntity->setPassword(
                $this->passwordEncoder->encodePassword($user['password'], $userEntity->getSalt())
            );
            $userEntity->setName($user['name']);
            $userEntity->setLastName($user['lastName']);
            $userEntity->setFullname($user['fullname']);
            $userEntity->setEmail($user['email']);

            $this->em->persist($userEntity);
            $this->em->flush();

            $io->success("{$user['username']} olusturuldu");
        }
    }
}