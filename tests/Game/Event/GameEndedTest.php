<?php

namespace Tests\Tiixstone\Game\Event;

use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tiixstone\Factory;
use Tiixstone\Game\Action\EndTurn;
use Tiixstone\Game\Event\GameEnded;

class GameEndedTest extends TestCase
{
    public function testEventFired()
    {
        $game = Factory::createForTest();

        $logger = new GameEndedLogger();
        $game->eventDispatcher->addSubscriber($logger);
        $this->assertNull($logger->event);

        $game->start();

        $game->action(new EndTurn());
        $game->action(new EndTurn());
        $game->action(new EndTurn());
        $game->action(new EndTurn());
        $game->action(new EndTurn());
        $game->action(new EndTurn());
        $game->action(new EndTurn());

        $this->assertInstanceOf(GameEnded::class, $logger->event);
    }
}

class GameEndedLogger implements EventSubscriberInterface
{
    /**
     * @var
     */
    public $event;

    public static function getSubscribedEvents()
    {
        return [
            GameEnded::NAME => 'GameEnded',
        ];
    }

    public function GameEnded(GameEnded $event)
    {
        $this->event = $event;
    }
}