<?php

namespace Tests\Tiixstone\Game\Event;

use Tiixstone\Factory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tiixstone\Game\Action\EndTurn;
use Tiixstone\Game\Action\MinionAttacksMinion;
use Tiixstone\Game\Action\PlayCard;
use Tiixstone\Game\Event\HeroDestroyed;

class HeroDestroyedTest extends TestCase
{
    public function testEventFired()
    {
        $game = Factory::createForTest();

        $logger = new HeroDestroyedLogger();
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

        $this->assertInstanceOf(HeroDestroyed::class, $logger->event);
    }
}

class HeroDestroyedLogger implements EventSubscriberInterface
{
    /**
     * @var
     */
    public $event;

    public static function getSubscribedEvents()
    {
        return [
            HeroDestroyed::NAME => 'process',
        ];
    }

    public function process(HeroDestroyed $event)
    {
        $this->event = $event;
    }
}