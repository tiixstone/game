<?php

namespace Tests\Tiixstone\Game\Event;

use Tiixstone\Factory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tiixstone\Game\Action\EndTurn;
use Tiixstone\Game\Action\MinionAttacksMinion;
use Tiixstone\Game\Action\PlayCard;
use Tiixstone\Game\Event\MinionAttackedMinion;

class MinionAttackedMinionTest extends TestCase
{
    public function testEventFired()
    {
        $game = Factory::createForTest(Factory::createCardsArray(30), Factory::createCardsArray(30));

        $logger = new MinionAttackedMinionLogger();
        $game->eventDispatcher->addSubscriber($logger);
        $this->assertNull($logger->event);

        $game->start();

        $game->action(new PlayCard($game->currentPlayer()->hand->first()));
        $game->action(new EndTurn());

        $game->action(new PlayCard($game->currentPlayer()->hand->first()));
        $game->action(new EndTurn());

        $game->action(new MinionAttacksMinion($game->currentPlayer()->board->first(), $game->idlePlayer()->board->first()));

        $this->assertInstanceOf(MinionAttackedMinion::class, $logger->event);
    }
}

class MinionAttackedMinionLogger implements EventSubscriberInterface
{
    /**
     * @var
     */
    public $event;

    public static function getSubscribedEvents()
    {
        return [
            MinionAttackedMinion::NAME => 'process',
        ];
    }

    public function process(MinionAttackedMinion $event)
    {
        $this->event = $event;
    }
}