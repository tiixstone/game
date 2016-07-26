<?php

namespace Tests\Tiixstone\Game\Action;

use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Tiixstone\Factory;
use Tiixstone\Game;
use Tiixstone\Game\Hero\Jaina;
use Tiixstone\Game\Manager\GameManager;

class EndTurnTest extends TestCase
{
    public function testMoveIncrements()
    {
        $game = Factory::createForTest();
        $game->start();
        $this->assertEquals(1, $game->turnNumber());

        $game->action(new Game\Action\EndTurn());
        $this->assertEquals(2, $game->turnNumber());

        $game->action(new Game\Action\EndTurn());
        $this->assertEquals(3, $game->turnNumber());
    }
}