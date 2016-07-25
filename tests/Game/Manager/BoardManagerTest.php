<?php

namespace Tests\Tiixstone\Game\Manager;

use PHPUnit\Framework\TestCase;
use Tiixstone\Factory;
use Tiixstone\Game\Card\Minion\ChillwindYeti;
use Tiixstone\Game\Card\Minion\Sheep;

class BoardManagerTest extends TestCase
{
    public function testSummonMinion()
    {
        $game = Factory::createForTest();

        $minion = new Sheep();
        $game->boardManager->summonMinion($game->currentPlayer(), $minion);

        $this->assertEquals($minion->id(), $game->currentPlayer()->board->first()->id());
    }

    public function testVacantPlaces()
    {
        $game = Factory::createForTest();
        $this->assertTrue($game->boardManager->hasVacantPlace($game->currentPlayer()));

        $game->currentPlayer()->board->appendMany([new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep()]);
        $this->assertFalse($game->boardManager->hasVacantPlace($game->currentPlayer()));
    }
}