<?php

namespace Tests\Tiixstone\Game\Event;

use Tiixstone\Factory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tiixstone\Game\Action\PlayCard;
use Tiixstone\Game\Event\PlayerGainedMana;

class PlayerGainedManaTest extends TestCase
{
    public function testEventFired()
    {
        $game = Factory::createForTest(Factory::createCardsArray(30), Factory::createCardsArray(30));

        $logger = new PlayerGainedManaLogger();
        $game->eventDispatcher->addSubscriber($logger);
        $this->assertNull($logger->event);

        $game->start();

        $game->action(new PlayCard($game->currentPlayer()->hand->first()));
        $this->assertInstanceOf(PlayerGainedMana::class, $logger->event);
    }
}

class PlayerGainedManaLogger implements EventSubscriberInterface
{
    /**
     * @var
     */
    public $event;

    public static function getSubscribedEvents()
    {
        return [
            PlayerGainedMana::NAME => 'process',
        ];
    }

    public function process(PlayerGainedMana $event)
    {
        $this->event = $event;
    }
}