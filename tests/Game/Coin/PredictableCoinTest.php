<?php

namespace Tests\Tiixstone\Game;

use PHPUnit\Framework\TestCase;
use Tiixstone\Game\Card\Collection\Board;
use Tiixstone\Game\Card\Collection\Deck;
use Tiixstone\Game\Card\Collection\Hand;
use Tiixstone\Game\Coin;
use Tiixstone\Game\Coin\RandomCoin;
use Tiixstone\Game\Hero\Jaina;
use Tiixstone\Game\Player;

class PredictableCoinTest extends TestCase
{
    public function testWorksCorrecly()
    {
        $player1Hero = new Jaina();
        $player2Hero = new Jaina();

        $player1Deck = new Deck([]);
        $player1Hand = new Hand([]);
        $player1Board = new Board([]);

        $player2Deck = new Deck([]);
        $player2Hand = new Hand([]);
        $player2Board = new Board([]);

        $player1 = new Player('Jonh Doe', $player1Hero, $player1Deck, $player1Hand, $player1Board);
        $player2 = new Player('Agent Smith', $player2Hero, $player2Deck, $player2Hand, $player2Board);

        $coin = new Coin\PredictableCoin();
        $coin->toss($player1, $player2);

        $this->assertEquals($player1->id(), $coin->winner()->id());
        $this->assertEquals($player2->id(), $coin->loser()->id());
    }
}