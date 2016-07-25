<?php

namespace Tests\Tiixstone\Game\Manager;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Tiixstone\Factory;
use Tiixstone\Game;
use Tiixstone\Game\Action\EndTurn;
use Tiixstone\Game\Hero\Jaina;
use Tiixstone\Game\Manager\BoardManager;
use Tiixstone\Game\Manager\GameManager;

class GameManagerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Game
     */
    protected $game;

    public function setUp()
    {
        $this->game = Factory::createForTest([
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
        ], [
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
            new Game\Card\Minion\Sheep(),
        ]);
    }

    public function testDrawingCardsAndFatigue()
    {
        $this->assertEquals(6, $this->game->player1->deck->count());
        $this->assertEquals(30, $this->game->player1->hero->health());

        $this->assertEquals(6, $this->game->player2->deck->count());
        $this->assertEquals(30, $this->game->player2->hero->health());

        $this->game->action(new EndTurn());

        $this->assertEquals(6, $this->game->player1->deck->count());
        $this->assertEquals(30, $this->game->player1->hero->health());

        $this->assertEquals(5, $this->game->player2->deck->count());
        $this->assertEquals(30, $this->game->player2->hero->health());

        $this->game->action(new EndTurn());
        $this->game->action(new EndTurn());
        $this->game->action(new EndTurn());
        $this->game->action(new EndTurn());
        $this->game->action(new EndTurn());
        $this->game->action(new EndTurn());
        $this->game->action(new EndTurn());
        $this->game->action(new EndTurn());
        $this->game->action(new EndTurn());
        $this->game->action(new EndTurn());
        $this->game->action(new EndTurn());

        $this->assertEquals(0, $this->game->player1->deck->count());
        $this->assertEquals(30, $this->game->player1->hero->health());

        $this->assertEquals(0, $this->game->player2->deck->count());
        $this->assertEquals(30, $this->game->player2->hero->health());

        $this->game->action(new EndTurn());

        $this->assertEquals(0, $this->game->player1->deck->count());
        $this->assertEquals(30, $this->game->player1->hero->health());

        $this->assertEquals(0, $this->game->player2->deck->count());
        $this->assertEquals(29, $this->game->player2->hero->health());

        $this->game->action(new EndTurn());

        $this->assertEquals(0, $this->game->player1->deck->count());
        $this->assertEquals(29, $this->game->player1->hero->health());

        $this->assertEquals(0, $this->game->player2->deck->count());
        $this->assertEquals(29, $this->game->player2->hero->health());

        $this->game->action(new EndTurn());

        $this->assertEquals(0, $this->game->player1->deck->count());
        $this->assertEquals(29, $this->game->player1->hero->health());

        $this->assertEquals(0, $this->game->player2->deck->count());
        $this->assertEquals(27, $this->game->player2->hero->health());
    }

    public function testPlayerHandCardsCount()
    {
        $this->assertEquals(4, $this->game->player1->hand->count());
        $this->assertEquals(5, $this->game->player2->hand->count());
    }

    public function testCurrentPlayerChangedAfterEndTurn()
    {
        $this->assertEquals($this->game->player1, $this->game->currentPlayer());

        $this->game->action(new EndTurn());
        $this->assertEquals($this->game->player2, $this->game->currentPlayer());

        $this->game->action(new EndTurn());
        $this->assertEquals($this->game->player1, $this->game->currentPlayer());

        $this->game->action(new EndTurn());
        $this->assertEquals($this->game->player2, $this->game->currentPlayer());
    }

    public function testManaCrystalsIncrease()
    {
        $this->assertEquals(1, $this->game->player1->manaCrystals());
        $this->assertEquals(0, $this->game->player2->manaCrystals());

        $this->assertEquals(1, $this->game->player1->availableMana());
        $this->assertEquals(0, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(1, $this->game->player1->manaCrystals());
        $this->assertEquals(1, $this->game->player2->manaCrystals());

        $this->assertEquals(1, $this->game->player1->availableMana());
        $this->assertEquals(1, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(2, $this->game->player1->manaCrystals());
        $this->assertEquals(1, $this->game->player2->manaCrystals());

        $this->assertEquals(2, $this->game->player1->availableMana());
        $this->assertEquals(1, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(2, $this->game->player1->manaCrystals());
        $this->assertEquals(2, $this->game->player2->manaCrystals());

        $this->assertEquals(2, $this->game->player1->availableMana());
        $this->assertEquals(2, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(3, $this->game->player1->manaCrystals());
        $this->assertEquals(2, $this->game->player2->manaCrystals());

        $this->assertEquals(3, $this->game->player1->availableMana());
        $this->assertEquals(2, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(3, $this->game->player1->manaCrystals());
        $this->assertEquals(3, $this->game->player2->manaCrystals());

        $this->assertEquals(3, $this->game->player1->availableMana());
        $this->assertEquals(3, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(4, $this->game->player1->manaCrystals());
        $this->assertEquals(3, $this->game->player2->manaCrystals());

        $this->assertEquals(4, $this->game->player1->availableMana());
        $this->assertEquals(3, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(4, $this->game->player1->manaCrystals());
        $this->assertEquals(4, $this->game->player2->manaCrystals());

        $this->assertEquals(4, $this->game->player1->availableMana());
        $this->assertEquals(4, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(5, $this->game->player1->manaCrystals());
        $this->assertEquals(4, $this->game->player2->manaCrystals());

        $this->assertEquals(5, $this->game->player1->availableMana());
        $this->assertEquals(4, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(5, $this->game->player1->manaCrystals());
        $this->assertEquals(5, $this->game->player2->manaCrystals());

        $this->assertEquals(5, $this->game->player1->availableMana());
        $this->assertEquals(5, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(6, $this->game->player1->manaCrystals());
        $this->assertEquals(5, $this->game->player2->manaCrystals());

        $this->assertEquals(6, $this->game->player1->availableMana());
        $this->assertEquals(5, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(6, $this->game->player1->manaCrystals());
        $this->assertEquals(6, $this->game->player2->manaCrystals());

        $this->assertEquals(6, $this->game->player1->availableMana());
        $this->assertEquals(6, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(7, $this->game->player1->manaCrystals());
        $this->assertEquals(6, $this->game->player2->manaCrystals());

        $this->assertEquals(7, $this->game->player1->availableMana());
        $this->assertEquals(6, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(7, $this->game->player1->manaCrystals());
        $this->assertEquals(7, $this->game->player2->manaCrystals());

        $this->assertEquals(7, $this->game->player1->availableMana());
        $this->assertEquals(7, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(8, $this->game->player1->manaCrystals());
        $this->assertEquals(7, $this->game->player2->manaCrystals());

        $this->assertEquals(8, $this->game->player1->availableMana());
        $this->assertEquals(7, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(8, $this->game->player1->manaCrystals());
        $this->assertEquals(8, $this->game->player2->manaCrystals());

        $this->assertEquals(8, $this->game->player1->availableMana());
        $this->assertEquals(8, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(9, $this->game->player1->manaCrystals());
        $this->assertEquals(8, $this->game->player2->manaCrystals());

        $this->assertEquals(9, $this->game->player1->availableMana());
        $this->assertEquals(8, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(9, $this->game->player1->manaCrystals());
        $this->assertEquals(9, $this->game->player2->manaCrystals());

        $this->assertEquals(9, $this->game->player1->availableMana());
        $this->assertEquals(9, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(10, $this->game->player1->manaCrystals());
        $this->assertEquals(9, $this->game->player2->manaCrystals());

        $this->assertEquals(10, $this->game->player1->availableMana());
        $this->assertEquals(9, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(10, $this->game->player1->manaCrystals());
        $this->assertEquals(10, $this->game->player2->manaCrystals());

        $this->assertEquals(10, $this->game->player1->availableMana());
        $this->assertEquals(10, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(10, $this->game->player1->manaCrystals());
        $this->assertEquals(10, $this->game->player2->manaCrystals());

        $this->assertEquals(10, $this->game->player1->availableMana());
        $this->assertEquals(10, $this->game->player2->availableMana());

        $this->game->action(new EndTurn());

        $this->assertEquals(10, $this->game->player1->manaCrystals());
        $this->assertEquals(10, $this->game->player2->manaCrystals());

        $this->assertEquals(10, $this->game->player1->availableMana());
        $this->assertEquals(10, $this->game->player2->availableMana());
    }
}