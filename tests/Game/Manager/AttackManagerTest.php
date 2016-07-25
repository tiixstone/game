<?php

namespace Tests\Tiixstone\Game\Manager;

use PHPUnit\Framework\TestCase;
use Tiixstone\Factory;
use Tiixstone\Game\Card\Minion\ChillwindYeti;

class AttackManagerTest extends TestCase
{
    public function testMinionTakesDamage()
    {
        $game = Factory::createForTest();

        $minion = new ChillwindYeti();
        $game->boardManager->summonMinion($game->player1, $minion);
        $this->assertEquals(5, $minion->health($game));

        $game->attackManager->minionTakeDamage($game, $minion, 3);
        $this->assertEquals(2, $minion->health($game));

        $game->attackManager->minionTakeDamage($game, $minion, 4);
        $this->assertEquals(-2, $minion->health($game));
    }
}