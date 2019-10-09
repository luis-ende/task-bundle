<?php

namespace Glooby\TaskBundle\Command\Scheduler;

use Glooby\TaskBundle\Queue\QueuePruner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Emil Kilhage
 */
class PruneCommand extends Command
{
    /** @var QueuePruner */
    private $pruner;

    public function __construct(QueuePruner $pruner){
        parent::__construct();
        $this->pruner = $pruner;
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('scheduler:prune');
        $this->addOption('all', 'A', InputOption::VALUE_NONE);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('all')) {
            $this->pruner->all();
        } else {
            $this->pruner->run();
        }
    }
}
