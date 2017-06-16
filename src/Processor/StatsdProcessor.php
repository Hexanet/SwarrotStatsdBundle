<?php

namespace Hexanet\SwarrotStatsdBundle\Processor;

use Hexanet\SwarrotStatsdBundle\Event\MessageEvent;
use Swarrot\Broker\Message;
use Swarrot\Processor\ConfigurableInterface;
use Swarrot\Processor\ProcessorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatsdProcessor implements ConfigurableInterface
{
    /**
     * @var ProcessorInterface
     */
    private $processor;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param ProcessorInterface       $processor
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(ProcessorInterface $processor, EventDispatcherInterface $eventDispatcher)
    {
        $this->processor = $processor;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Message $message, array $options)
    {
        $startTiming = gettimeofday(true);

        try {
            $result = $this->processor->process($message, $options);

            $this->dispatchEvent(MessageEvent::SUCCESS, $options, $startTiming);
        } catch (\Exception $e) {
            $this->dispatchEvent(MessageEvent::ERROR, $options, $startTiming);

            throw $e;
        }

        return $result;
    }

    /**
     * @param string     $type
     * @param array      $options
     * @param float|null $startTiming
     */
    private function dispatchEvent(string $type, array $options, float $startTiming = null)
    {
        $name = $options['name'] ?? $options['queue'];
        $timing = null;

        if ($startTiming) {
            $timing = (gettimeofday(true) - $startTiming) * 1000;
        }

        $event = new MessageEvent($name, $options['connection'], $options['queue'], $timing);

        $this->eventDispatcher->dispatch($type, $event);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined('name');
        $resolver->setAllowedTypes('name', 'string');
    }
}
