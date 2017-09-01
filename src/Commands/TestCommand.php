<?php

namespace Slim\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/8/31
 * Time: 17:45
 */
class TestCommand extends Command
{

    protected function configure()
    {

        parent::configure();
        $this->setName('slim:test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

         echo 'x';
    }
}
