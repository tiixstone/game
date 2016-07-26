<?php

namespace Tests\Tiixstone;

use PHPUnit\Framework\TestCase;
use Tiixstone\Factory;
use Tiixstone\Game;
use Tiixstone\Game\Action\EndTurn;
use Tiixstone\Game\Action\PlayCard;
use Tiixstone\Game\Card\Minion\Sheep;
use Tiixstone\Game\Card\Spell\TheCoin;

class GameTest extends TestCase
{
    public function testSimpleGamePlay()
    {
        $player1Deck = [];
        for($i=0; $i<30; $i++) {
            $player1Deck[] = new Sheep();
        }

        $player2Deck = [];
        for($i=0; $i<30; $i++) {
            $player2Deck[] = new Sheep();
        }

        $game = Factory::createForTest($player1Deck, $player2Deck);
        $game->start();

        // начало игры, 1 ход __________________________________________________________________________________________
        $this->assertTrue($game->isPlayerCurrent($game->player1));
        $this->checkPlayer($game->player1, 4, 26, 0, 0, 1, 1);
        $this->checkPlayer($game->player2, 5, 26, 0, 0, 0, 0);

        $game->action(new EndTurn());

        // 2 ход _______________________________________________________________________________________________________
        $this->checkTurnBegin($game, 2);
        $this->assertTrue($game->isPlayerCurrent($game->player2));
        $this->checkPlayer($game->player1, 4, 26, 0, 0, 1, 1);
        $this->checkPlayer($game->player2, 6, 25, 0, 0, 1, 1);

        // разыгрываем монетку
        $coin = false;

        foreach($game->currentPlayer()->hand->all() as $card) {
            if($card instanceof TheCoin) {
                $coin = $card;
                break;
            }
        }

        $this->assertTrue(is_object($coin));

        $game->action(new PlayCard($coin));

        $this->checkPlayer($game->currentPlayer(), 5, 25, 0, 0, 2, 1);

        // выставляем двух овец
        $game->action(new PlayCard($game->currentPlayer()->hand->first()));
        $game->action(new PlayCard($game->currentPlayer()->hand->first()));

        $this->checkPlayer($game->currentPlayer(), 3, 25, 2, 0, 0, 1);

        $game->action(new EndTurn());

        // 3 ход________________________________________________________________________________________________________
        $this->checkTurnBegin($game, 3);
        $this->assertTrue($game->isPlayerCurrent($game->player1));
        $this->checkPlayer($game->player1, 5, 25, 0, 0, 2, 2);
        $this->checkPlayer($game->player2, 3, 25, 2, 0, 0, 1);

        // выставляем двух овец
        $game->action(new PlayCard($game->currentPlayer()->hand->first()));
        $game->action(new PlayCard($game->currentPlayer()->hand->first()));

        $this->checkPlayer($game->player1, 3, 25, 2, 0, 0, 2);

        $game->action(new EndTurn());

        // 4 ход________________________________________________________________________________________________________
        $this->checkTurnBegin($game, 4);
        $this->assertTrue($game->isPlayerCurrent($game->player2));
        $this->checkPlayer($game->player1, 3, 25, 2, 0, 0, 2);
        $this->checkPlayer($game->player2, 4, 24, 2, 0, 2, 2);

        // атакуем овцами
        $minionAttacker1 = $game->player2->board->first();
        $minionTarget1 = $game->player1->board->first();
        $game->action(new Game\Action\MinionAttacksMinion($minionAttacker1, $minionTarget1));

        $this->checkPlayer($game->player1, 3, 25, 1, 1, 0, 2);
        $this->checkPlayer($game->player2, 4, 24, 1, 1, 2, 2);

        $game->action(new EndTurn());

        // 5 ход________________________________________________________________________________________________________
        $this->checkTurnBegin($game, 5);
        $this->assertTrue($game->isPlayerCurrent($game->player1));
        $this->checkPlayer($game->player1, 4, 24, 1, 1, 3, 3);
        $this->checkPlayer($game->player2, 4, 24, 1, 1, 2, 2);
        $this->checkHero($game->player1->hero, 30);
        $this->checkHero($game->player2->hero, 30);
    }

    private function checkTurnBegin(Game $game, $moveNumber)
    {
        $this->assertFalse($game->isOver());
        $this->assertEquals($moveNumber, $game->turnNumber());
    }

    private function checkPlayer(Game\Player $player, $handCount, $deckCount, $boardCount, $graveyardCount, $manaAvailable, $maximumMana)
    {
        $this->assertEquals($handCount, $player->hand->count());
        $this->assertEquals($deckCount, $player->deck->count());
        $this->assertEquals($boardCount, $player->board->count());
        $this->assertEquals($graveyardCount, $player->graveyard->count());

        $this->assertEquals($manaAvailable, $player->availableMana());
        $this->assertEquals($maximumMana, $player->maximumMana());
    }

    private function checkHero(Game\Hero $hero, $health)
    {
        $this->assertEquals($health, $hero->health());
    }
}