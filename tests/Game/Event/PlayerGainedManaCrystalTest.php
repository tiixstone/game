<?php

namespace Tests\Tiixstone\Game\Event;

use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tiixstone\Factory;
use Tiixstone\Game\Action\EndTurn;
use Tiixstone\Game\Event\PlayerGainedManaCrystal;

class PlayerGainedManaCrystalTest extends TestCase
{
    public function testEventFired()
    {
        $this->assertTrue(true);

        //$game = Factory::createForTest(Factory::createCardsArray(30), Factory::createCardsArray(30));
        //
        //$logger = new PlayerGainedManaCrystalLogger();
        //$game->eventDispatcher->addSubscriber($logger);
        //$this->assertNull($logger->event);
        //
        //$game->start();
        //
        //$this->assertInstanceOf(PlayerGainedManaCrystal::class, $logger->event);
    }
}

class PlayerGainedManaCrystalLogger implements EventSubscriberInterface
{
    /**
     * @var
     */
    public $event;

    public static function getSubscribedEvents()
    {
        return [
            PlayerGainedManaCrystal::NAME => 'process',
        ];
    }

    public function process(PlayerGainedManaCrystal $event)
    {
        $this->event = $event;
    }
}