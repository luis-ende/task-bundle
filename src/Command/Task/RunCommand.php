<?php

namespace Glooby\TaskBundle\Command\Task;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Glooby\TaskBundle\Task\TaskRunner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Emil Kilhage
 */
class RunCommand extends Command
{
    protected static $defaultName = 'task:run';

    /** @var EntityManagerInterface */
    private $em;

    /** @var TaskRunner */
    private $runner;

    public function __construct(EntityManagerInterface $em, TaskRunner $runner){
        parent::__construct();
        $this->em = $em;
        $this->runner = $runner;
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('task:run');
        $this->addArgument('service', InputArgument::OPTIONAL);
        $this->addOption('silent', 'S', InputOption::VALUE_NONE);
        $this->addOption('id', null, InputOption::VALUE_REQUIRED);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->runner->setOutput($output);

        if ($input->getOption('id')) {
            $response = $this->runId($input);

            if (!$input->getOption('silent')) {
                if (!empty($response)) {
                    $output->writeln("task {$input->getOption('id')} finished: $response");
                } else {
                    $output->writeln("task {$input->getOption('id')} finished");
                }
            }
        } else {
            $response = $this->runner->runTask($input->getArgument('service'));

            if (!$input->getOption('silent')) {
                $output->writeln($response);
            }
        }
    }

    /**
     * @param InputInterface $input
     * @param TaskRunner $runner
     * @throws NoResultException
     */
    protected function runId(InputInterface $input)
    {
        $task = $this->em->getRepository('GloobyTaskBundle:QueuedTask')->find($input->getOption('id'));

        if (null === $task) {
            throw new NoResultException();
        }

        return $this->runner->run($task);
    }
}
