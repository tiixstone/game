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

        $this->assertEquals(1, $game->currentPlayer()->availableMana());
        $this->assertEquals(1, $game->currentPlayer()->manaCrystals());

        $theCoin = new Game\Card\Spell\TheCoin();
        $game->currentPlayer()->hand->append($theCoin);

        $game->action(new Game\Action\PlayCard($theCoin));

        $this->assertEquals(2, $game->currentPlayer()->availableMana());
        $this->assertEquals(1, $game->currentPlayer()->manaCrystals());
    }    
}