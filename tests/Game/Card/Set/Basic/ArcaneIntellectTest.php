<?php

namespace Tests\Tiixstone\Game\Card\Spell;

use PHPUnit\Framework\TestCase;
use Tiixstone\Factory;
use Tiixstone\Game;

class ArcaneIntellectTest extends TestCase
{
    public function testCast()
    {
        $game = Factory::createForTest(
            Factory::createCardsArray(30, Game\Card\Set\Basic\ChillwindYeti::class),
            Factory::createCardsArray(30, Game\Card\Set\Basic\ChillwindYeti::class)
        );

        $game->start();
        $this->assertEquals(4, $game->currentPlayer()->hand->count());

        (new Game\Card\Set\Basic\ArcaneIntellect())->cast($game);
        $this->assertEquals(6, $game->currentPlayer()->hand->count());
    }
}