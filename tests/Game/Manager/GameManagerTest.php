<?php

namespace Tests\Tiixstone\Game\Manager;

use Tiixstone\Game;
use Tiixstone\Game\Action\EndTurn;
use Tiixstone\Game\Hero\Jaina;
use Tiixstone\Game\Manager\GameManager;

class GameManagerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Game
     */
    protected $game;

    public function setUp()
    {
        $player1Hero = new Jaina();
        $player2Hero = new Jaina();

        $player1Deck = new Game\Card\Collection\Deck([
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
        $player1Hand = new Game\Card\Collection\Hand([]);
        $player1Board = new Game\Card\Collection\Board([]);

        $player2Deck = new Game\Card\Collection\Deck([
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
        $player2Hand = new Game\Card\Collection\Hand([]);
        $player2Board = new Game\Card\Collection\Board([]);

        $player1 = new \Tiixstone\Game\Player('Jonh Doe', $player1Hero, $player1Deck, $player1Hand, $player1Board);
        $player2 = new \Tiixstone\Game\Player('Agent Smith', $player2Hero, $player2Deck, $player2Hand, $player2Board);

        $gameManager = new GameManager();
        $cardsManager = new Game\Manager\CardsManager();

        $this->game = new \Tiixstone\Game($player1, $player2, $gameManager, $cardsManager);
    }

    public function testSimpleGamePlay()
    {
        $this->assertTrue(!$this->game->isOver());
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

    public function testMoveNumberIncrease()
    {
        $this->assertEquals(0, $this->game->moveNumber());

        $this->game->action(new EndTurn());
        $this->assertEquals(1, $this->game->moveNumber());

        $this->game->action(new EndTurn());
        $this->assertEquals(2, $this->game->moveNumber());
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