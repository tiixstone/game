<?php

namespace Tests\Tiixstone\Game\Card\Spell;

use PHPUnit\Framework\TestCase;
use Tiixstone\Factory;
use Tiixstone\Game;

class ArcaneMissilesTest extends TestCase
{
    public function testCast()
    {
        $game = Factory::createForTest(
            Factory::createCardsArray(30, Game\Card\Set\Basic\ChillwindYeti::class),
            Factory::createCardsArray(30, Game\Card\Set\Basic\ChillwindYeti::class)
        );

        $game->start();

        $this->assertEquals(30, $game->idlePlayer()->hero->health());

        (new Game\Card\Set\Basic\ArcaneMissiles())->cast($game);
        $this->assertEquals(27, $game->idlePlayer()->hero->health());

        $game->boardManager->summonMinion($game->idlePlayer(), new Game\Card\Set\Basic\ChillwindYeti());
        $game->boardManager->summonMinion($game->idlePlayer(), new Game\Card\Set\Basic\ChillwindYeti());
        $game->boardManager->summonMinion($game->idlePlayer(), new Game\Card\Set\Basic\ChillwindYeti());
        $game->boardManager->summonMinion($game->idlePlayer(), new Game\Card\Set\Basic\ChillwindYeti());
        $game->boardManager->summonMinion($game->idlePlayer(), new Game\Card\Set\Basic\ChillwindYeti());
        $game->boardManager->summonMinion($game->idlePlayer(), new Game\Card\Set\Basic\ChillwindYeti());
        $game->boardManager->summonMinion($game->idlePlayer(), new Game\Card\Set\Basic\ChillwindYeti());

        $this->assertEquals(7, $game->idlePlayer()->board->count());

        (new Game\Card\Set\Basic\ArcaneMissiles())->cast($game);
        $this->assertNotEquals(24, $game->idlePlayer()->hero->health());

        $totalHealth = $game->idlePlayer()->hero->health();

        /** @var Game\Card\Minion $minion */
        foreach($game->idlePlayer()->board->all() as $minion) {
            $totalHealth += $minion->health($game);
        }

        $this->assertEquals(59, $totalHealth);
    }
}