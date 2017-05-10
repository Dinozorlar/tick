<?php
namespace Tick\ConsoleCommands;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateDefaultUsers extends Command
{
    public function configure()
    {
        $this
            ->setName('tick:system:create-default-users')
            ->setDescription('Default userlari olusturur')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $users = [
            [
                'id' => Uuid::uuid4(),
                'username' => 'cankat',
                'password' => '123456',
                'salt' => ''
            ]
        ];
    }
}