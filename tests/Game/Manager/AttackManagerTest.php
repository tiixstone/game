<?php

namespace Tests\Tiixstone\Game\Manager;

use PHPUnit\Framework\TestCase;
use Tiixstone\Factory;
use Tiixstone\Game\Card\Minion\Sheep;
use Tiixstone\Game\Card\Set\Basic\ChillwindYeti;

class AttackManagerTest extends TestCase
{
    public function testMinionTakesDamage()
    {
        $game = Factory::createForTest();
        $game->start();

        $minion = new ChillwindYeti();
        $game->boardManager->summonMinion($game->player1, $minion);
        $this->assertEquals(5, $minion->health($game));

        $game->attackManager->minionTakeDamage($game, $minion, 3);
        $this->assertEquals(2, $minion->health($game));

        $game->attackManager->minionTakeDamage($game, $minion, 4);
        $this->assertEquals(-2, $minion->health($game));
    }

    public function testHeroTakeDamage()
    {
        $game = Factory::createForTest([new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep()]);
        $game->start();
        $this->assertEquals(30, $game->currentPlayer()->hero->health());

        $game->attackManager->heroTakeDamage($game, $game->currentPlayer()->hero, 10);
        $this->assertEquals(20, $game->currentPlayer()->hero->health());
    }
}