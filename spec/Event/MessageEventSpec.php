<?php

namespace spec\Hexanet\SwarrotStatsdBundle\Event;

use Hexanet\SwarrotStatsdBundle\Event\MessageEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageEventSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            'my_message_name',
            'my_connection',
            'my_queue',
            189765
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MessageEvent::class);
    }

    function it_returns_message_name()
    {
        $this->getMessageName()->shouldReturn('my_message_name');
    }

    function it_returns_connection()
    {
        $this->getConnection()->shouldReturn('my_connection');
    }

    function it_returns_queue()
    {
        $this->getQueue()->shouldReturn('my_queue');
    }

    function it_returns_timing()
    {
        $this->getTiming()->shouldReturn((float) 189765);
    }
}
