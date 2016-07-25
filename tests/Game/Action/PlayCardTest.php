<?php

namespace Tests\Tiixstone\Game\Action;

use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Tiixstone\Factory;
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

    public function testMinionPlayed()
    {
        $this->assertEquals(0, $this->game->currentPlayer()->board->count());
        $this->assertEquals(4, $this->game->currentPlayer()->hand->count());

        $this->game->action(new Game\Action\PlayCard($this->game->currentPlayer()->hand->first()->id()));

        $this->assertEquals(1, $this->game->currentPlayer()->board->count());
        $this->assertEquals(3, $this->game->currentPlayer()->hand->count());
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