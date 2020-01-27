<?php

namespace Glooby\TaskBundle\Command\Scheduler;

use Glooby\TaskBundle\Queue\QueueMonitor;
use Glooby\TaskBundle\Queue\QueueProcessor;
use Glooby\TaskBundle\Queue\QueueScheduler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Emil Kilhage
 */
class RunCommand extends Command
{
    /** @var QueueMonitor */
    private $monitor;

    /** @var QueueProcessor */
    private $processor;

    /** @var QueueScheduler */
    private $scheduler;

    public function __construct(
        QueueMonitor $monitor,
        QueueProcessor $processor,
        QueueScheduler $scheduler
    ) {
        parent::__construct();
        $this->monitor = $monitor;
        $this->processor = $processor;
        $this->scheduler = $scheduler;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('scheduler:run');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->processor->setOutput($output);
        $this->processor->process();
        $this->monitor->monitor();
        $this->scheduler->schedule();
    }
}
