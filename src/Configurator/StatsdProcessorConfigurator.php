<?php

namespace Hexanet\SwarrotStatsdBundle\Configurator;

use Hexanet\SwarrotStatsdBundle\Processor\StatsdProcessor;
use Swarrot\SwarrotBundle\Processor\ProcessorConfiguratorEnableAware;
use Swarrot\SwarrotBundle\Processor\ProcessorConfiguratorExtrasAware;
use Swarrot\SwarrotBundle\Processor\ProcessorConfiguratorInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class StatsdProcessorConfigurator implements ProcessorConfiguratorInterface
{
    use ProcessorConfiguratorEnableAware, ProcessorConfiguratorExtrasAware;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessorArguments(array $options)
    {
        return [
            StatsdProcessor::class,
            $this->eventDispatcher,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCommandOptions()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function resolveOptions(InputInterface $input)
    {
        return $this->getExtras();
    }
}
