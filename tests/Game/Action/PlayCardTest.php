<?php

namespace Tests\Tiixstone\Game\Action;

use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Tiixstone\Game;
use Tiixstone\Game\Hero\Jaina;
use Tiixstone\Game\Manager\GameManager;

class PlayCardTest extends TestCase
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

        $eventDispatcher = new EventDispatcher();
        $gameManager = new GameManager();
        $cardsManager = new Game\Manager\CardsManager();
        $boardManager = new Game\Manager\BoardManager();

        $this->game = new \Tiixstone\Game($player1, $player2, $eventDispatcher, $gameManager, $cardsManager, $boardManager);
    }

    public function testPlayerDoesNotHaveCardWithRequiredKey()
    {
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::PLAYER_DOESNT_HAVE_CARD_IN_HAND_WITH_REQUIRED_KEY);

        $this->game->action(new Game\Action\PlayCard('123'));
    }

    public function testPlayerDoenNotHaveEnoughManaToPlayCard()
    {
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::PLAYER_DOESNT_HAVE_ENOUGH_MANA_TO_PLAY_CARD);
        
        $card = $this->game->currentPlayer()->hand->first();
        $this->game->action(new Game\Action\PlayCard($card->id()));

        $card = $this->game->currentPlayer()->hand->first();
        $this->game->action(new Game\Action\PlayCard($card->id()));


    }
}