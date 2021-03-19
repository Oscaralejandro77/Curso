<?php


namespace app\commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class helloWorldCommand extends Command
{
    protected static $defaultName = 'app:hello-world';

    public function configure()
    {
        $this

            ->addArgument('name', InputArgument::REQUIRED, 'name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
       $output->writeln('HELLO ' . $input->getArgument('name'));
    }
}