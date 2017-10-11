<?php

namespace spec\Hexanet\SwarrotStatsdBundle\Configurator;

use Hexanet\SwarrotStatsdBundle\Configurator\StatsdProcessorConfigurator;
use Hexanet\SwarrotStatsdBundle\Processor\StatsdProcessor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class StatsdProcessorConfiguratorSpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $eventDispatcher)
    {
        $this->beConstructedWith($eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(StatsdProcessorConfigurator::class);
    }

    function it_returns_processor_arguments($eventDispatcher)
    {
        $this->getProcessorArguments([])->shouldReturn([
            StatsdProcessor::class,
            $eventDispatcher,
        ]);
    }

    function it_returns_command_options()
    {
        $this->getCommandOptions()->shouldReturn([]);
    }

    function it_resolves_options(InputInterface $input)
    {
        $this->resolveOptions($input)->shouldReturn([]);
    }
}
