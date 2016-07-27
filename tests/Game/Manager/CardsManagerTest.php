<?php

namespace Tests\Tiixstone\Game\Manager;

use PHPUnit\Framework\TestCase;
use Tiixstone\Factory;
use Tiixstone\Game\Card\Collection\Board;
use Tiixstone\Game\Card\Collection\Deck;
use Tiixstone\Game\Card\Collection\Hand;
use Tiixstone\Game\Card\Minion\Sheep;
use Tiixstone\Game\Exception;
use Tiixstone\Game\Hero\Jaina;
use Tiixstone\Game\Manager\CardsManager;
use Tiixstone\Game\Player;

class CardsManagerTest extends TestCase
{
    public function testDraw()
    {
        $game = Factory::createForTest(Factory::createCardsArray(30), Factory::createCardsArray(30));
        $game->start();

        $this->assertEquals(4, $game->currentPlayer()->hand->count());

        $game->cardsManager->draw($game, $game->currentPlayer());
        $this->assertEquals(5, $game->currentPlayer()->hand->count());
    }

    public function testOverdraw()
    {
        $game = Factory::createForTest(Factory::createCardsArray(30), Factory::createCardsArray(30));
        $game->start();

        $this->assertEquals(4, $game->currentPlayer()->hand->count());

        $game->cardsManager->drawMany($game, $game->currentPlayer(), 6);
        $this->assertEquals(10, $game->currentPlayer()->hand->count());

        $game->cardsManager->draw($game, $game->currentPlayer());
        $this->assertEquals(10, $game->currentPlayer()->hand->count());
    }
}