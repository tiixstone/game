<?php

namespace Tests\Tiixstone\Game\Event;

use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tiixstone\Factory;
use Tiixstone\Game\Event\GameStarted;

class GameStartedTest extends TestCase
{
    public function testEventFired()
    {
        $game = Factory::createForTest(Factory::createCardsArray(30), Factory::createCardsArray(30));

        $logger = new GameStartedLogger();
        $game->eventDispatcher->addSubscriber($logger);
        $this->assertNull($logger->event);

        $game->start();
        $this->assertInstanceOf(GameStarted::class, $logger->event);
    }
}

class GameStartedLogger implements EventSubscriberInterface
{
    /**
     * @var
     */
    public $event;

    public static function getSubscribedEvents()
    {
        return [
            GameStarted::NAME => 'gameStarted',
        ];
    }

    public function gameStarted(GameStarted $event)
    {
        $this->event = $event;
    }
}