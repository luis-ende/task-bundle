<?php

namespace Glooby\TaskBundle\Tests\DependencyInjection;

use Glooby\TaskBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

/**
 * @author Emil Kilhage
 */
class ConfigurationTest extends TestCase
{
    /**
     * @var Processor
     */
    private $processor;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->processor = new Processor();
    }

    private function getConfigs(array $configArray)
    {
        $configuration = new Configuration(true);

        return $this->processor->processConfiguration($configuration, array($configArray));
    }

    public function testUnConfiguredConfiguration()
    {
        $configuration = $this->getConfigs(array());
        $this->assertSame(array(), $configuration);
    }
}
