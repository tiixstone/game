<?php

namespace Tests\Tiixstone\Game\Card\Spell;

use PHPUnit\Framework\TestCase;
use Tiixstone\Factory;
use Tiixstone\Game;

class TheCoinTest extends TestCase
{
    public function testAddMana()
    {
        $game = Factory::createForTest();
        $game->start();

        $this->assertEquals(1, $game->currentPlayer()->maximumMana());
        $this->assertEquals(1, $game->currentPlayer()->availableMana());

        $theCoin = new Game\Card\Set\Basic\TheCoin();
        $game->currentPlayer()->hand->append($theCoin);

        $game->action(new Game\Action\PlayCard($theCoin));

        $this->assertEquals(1, $game->currentPlayer()->maximumMana());
        $this->assertEquals(2, $game->currentPlayer()->availableMana());

        $game->action(new Game\Action\EndTurn());

        $this->assertEquals(1, $game->idlePlayer()->maximumMana());
        $this->assertEquals(2, $game->idlePlayer()->availableMana());

        $game->action(new Game\Action\EndTurn());

        $this->assertEquals(2, $game->currentPlayer()->maximumMana());
        $this->assertEquals(2, $game->currentPlayer()->availableMana());

        $game->action(new Game\Action\EndTurn());
        $game->action(new Game\Action\EndTurn());

        $this->assertEquals(3, $game->currentPlayer()->maximumMana());
        $this->assertEquals(3, $game->currentPlayer()->availableMana());
    }
}