<?php

namespace Tests\Tiixstone\Game\Event;

use Tiixstone\Factory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tiixstone\Game\Action\EndTurn;
use Tiixstone\Game\Action\MinionAttacksMinion;
use Tiixstone\Game\Action\PlayCard;
use Tiixstone\Game\Event\MinionTookDamage;

class MinionTookDamageTest extends TestCase
{
    public function testEventFired()
    {
        $game = Factory::createForTest(Factory::createCardsArray(30), Factory::createCardsArray(30));

        $logger = new MinionTookDamageLogger();
        $game->eventDispatcher->addSubscriber($logger);
        $this->assertNull($logger->event);

        $game->start();

        $game->action(new PlayCard($game->currentPlayer()->hand->first()));
        $game->action(new EndTurn());

        $game->action(new PlayCard($game->currentPlayer()->hand->first()));
        $game->action(new EndTurn());

        $game->action(new MinionAttacksMinion($game->currentPlayer()->board->first(), $game->idlePlayer()->board->first()));

        $this->assertInstanceOf(MinionTookDamage::class, $logger->event);
    }
}

class MinionTookDamageLogger implements EventSubscriberInterface
{
    /**
     * @var
     */
    public $event;

    public static function getSubscribedEvents()
    {
        return [
            MinionTookDamage::NAME => 'process',
        ];
    }

    public function process(MinionTookDamage $event)
    {
        $this->event = $event;
    }
}