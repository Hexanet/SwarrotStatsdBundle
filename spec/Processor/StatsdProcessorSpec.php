<?php

namespace spec\Hexanet\SwarrotStatsdBundle\Processor;

use Hexanet\SwarrotStatsdBundle\Event\MessageEvent;
use Hexanet\SwarrotStatsdBundle\Processor\StatsdProcessor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Swarrot\Broker\Message;
use Swarrot\Processor\ProcessorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class StatsdProcessorSpec extends ObjectBehavior
{
    function let(ProcessorInterface $processor, EventDispatcherInterface $eventDispatcher)
    {
        $this->beConstructedWith($processor, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(StatsdProcessor::class);
    }

    function it_dispatch_success_event_if_no_errors(EventDispatcherInterface $eventDispatcher)
    {
        $message = new Message('my_body', [], 1);
        $options = [
            'exchange'    => 'my_exchange',
            'connection'  => 'my_connection',
            'routing_key' => 'my_routing_key',
            'queue' => 'my_queue',
        ];

        $eventDispatcher->dispatch(MessageEvent::SUCCESS, Argument::allOf(
            Argument::type(MessageEvent::class),
            Argument::which('getMessageName', 'my_queue'),
            Argument::which('getConnection', 'my_connection'),
            Argument::which('getQueue', 'my_queue')
        ))->shouldBeCalled();

        $this->process($message, $options);
    }

    function it_dispatch_error_event_if_errors(ProcessorInterface $processor, EventDispatcherInterface $eventDispatcher)
    {
        $message = new Message('my_body', [], 1);
        $options = [
            'exchange'    => 'my_exchange',
            'connection'  => 'my_connection',
            'routing_key' => 'my_routing_key',
            'queue' => 'my_queue',
        ];

        $processor->process($message, $options)->willThrow(\BadMethodCallException::class);
        $eventDispatcher->dispatch(MessageEvent::ERROR, Argument::type(MessageEvent::class))->shouldBeCalled();

        $this->shouldThrow(\BadMethodCallException::class)->duringProcess($message, $options);
    }

    function it_uses_custom_name_from_options(EventDispatcherInterface $eventDispatcher)
    {
        $message = new Message('my_body', [], 1);
        $options = [
            'name' => 'my_message_name',
            'exchange'    => 'my_exchange',
            'connection'  => 'my_connection',
            'routing_key' => 'my_routing_key',
            'queue' => 'my_queue',
        ];

        $eventDispatcher->dispatch(MessageEvent::SUCCESS, Argument::allOf(
            Argument::type(MessageEvent::class),
            Argument::which('getMessageName', 'my_message_name'),
            Argument::which('getConnection', 'my_connection'),
            Argument::which('getQueue', 'my_queue')
        ))->shouldBeCalled();

        $this->process($message, $options);
    }
}
