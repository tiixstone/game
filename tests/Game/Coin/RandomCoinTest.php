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

class RandomCoinTest extends TestCase
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

        $coin = new RandomCoin();
        $coin->toss($player1, $player2);

        $this->assertTrue($coin->winner()->id() == $player1->id() OR $coin->winner()->id() == $player2->id());
        $this->assertTrue($coin->loser()->id() == $player1->id() OR $coin->loser()->id() == $player2->id());
    }
}