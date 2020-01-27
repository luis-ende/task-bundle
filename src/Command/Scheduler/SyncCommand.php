<?php

namespace Glooby\TaskBundle\Command\Scheduler;

use Glooby\TaskBundle\Synchronizer\ScheduleSynchronizer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Emil Kilhage
 */
class SyncCommand extends Command
{
    /** @var ScheduleSynchronizer */
    private $synchronizer;

    public function __construct(ScheduleSynchronizer $synchronizer){
        parent::__construct();
        $this->synchronizer = $synchronizer;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('scheduler:sync');
        $this->addOption('silent', 'S', InputOption::VALUE_NONE);
        $this->addOption('force', 'F', InputOption::VALUE_NONE);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->synchronizer->setForce($input->getOption('force'));
        $this->synchronizer->sync();
    }
}
