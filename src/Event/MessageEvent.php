<?php

namespace Hexanet\SwarrotStatsdBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class MessageEvent extends Event
{
    const SUCCESS = 'swarrot_statsd.message.success';
    const ERROR = 'swarrot_statsd.message.error';

    /**
     * @var string
     */
    private $messageName;

    /**
     * @var string
     */
    private $connection;

    /**
     * @var string
     */
    private $queue;

    /**
     * @var float
     */
    private $timing;

    /**
     * @param string     $messageName
     * @param string     $connection
     * @param string     $queue
     * @param float|null $timing
     */
    public function __construct(string $messageName, string $connection, string $queue, float $timing = null)
    {
        $this->messageName = $messageName;
        $this->connection = $connection;
        $this->queue = $queue;
        $this->timing = $timing;
    }

    /**
     * @return string
     */
    public function getMessageName() : string
    {
        return $this->messageName;
    }

    /**
     * @return string
     */
    public function getConnection() : string
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function getQueue() : string
    {
        return $this->queue;
    }

    /**
     * @return float
     */
    public function getTiming(): ? float
    {
        return $this->timing;
    }
}
