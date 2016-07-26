<?php

namespace Tests\Tiixstone\Game\Event;

use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tiixstone\Factory;
use Tiixstone\Game\Action\EndTurn;
use Tiixstone\Game\Event\TurnEnded;

class TurnEndedTest extends TestCase
{
    public function testEventFired()
    {
        $game = Factory::createForTest(Factory::createCardsArray(30), Factory::createCardsArray(30));

        $logger = new TurnEndedLogger();
        $game->eventDispatcher->addSubscriber($logger);
        $this->assertNull($logger->event);

        $game->start();

        $game->action(new EndTurn());
        $this->assertInstanceOf(TurnEnded::class, $logger->event);
    }
}

class TurnEndedLogger implements EventSubscriberInterface
{
    /**
     * @var
     */
    public $event;

    public static function getSubscribedEvents()
    {
        return [
            TurnEnded::NAME => 'process',
        ];
    }

    public function process(TurnEnded $event)
    {
        $this->event = $event;
    }
}