<?php

namespace Tests\Tiixstone\Game\Event;

use Tiixstone\Factory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tiixstone\Game\Action\EndTurn;
use Tiixstone\Game\Action\PlayCard;
use Tiixstone\Game\Event\FatigueDealt;

class FatigueDealtTest extends TestCase
{
    public function testEventFired()
    {
        $game = Factory::createForTest();

        $logger = new FatigueDealtLogger();
        $game->eventDispatcher->addSubscriber($logger);
        $this->assertNull($logger->event);

        $game->start();

        $game->action(new EndTurn());

        $this->assertInstanceOf(FatigueDealt::class, $logger->event);
    }
}

class FatigueDealtLogger implements EventSubscriberInterface
{
    /**
     * @var
     */
    public $event;

    public static function getSubscribedEvents()
    {
        return [
            FatigueDealt::NAME => 'process',
        ];
    }

    public function process(FatigueDealt $event)
    {
        $this->event = $event;
    }
}