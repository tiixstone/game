<?php

namespace Tests\Tiixstone\Game\Event;

use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tiixstone\Factory;
use Tiixstone\Game\Action\EndTurn;
use Tiixstone\Game\Event\TurnBegan;

class TurnBeganTest extends TestCase
{
    public function testEventFired()
    {
        $game = Factory::createForTest(Factory::createCardsArray(30), Factory::createCardsArray(30));

        $logger = new TurnBeganLogger();
        $game->eventDispatcher->addSubscriber($logger);
        $this->assertNull($logger->event);

        $game->start();

        $game->action(new EndTurn());
        $this->assertInstanceOf(TurnBegan::class, $logger->event);
    }
}

class TurnBeganLogger implements EventSubscriberInterface
{
    /**
     * @var
     */
    public $event;

    public static function getSubscribedEvents()
    {
        return [
            TurnBegan::NAME => 'process',
        ];
    }

    public function process(TurnBegan $event)
    {
        $this->event = $event;
    }
}