<?php

namespace Tiixstone;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Tiixstone\Game\Hero\Jaina;
use Tiixstone\Game\Manager\BoardManager;
use Tiixstone\Game\Manager\GameManager;

class Factory
{
    public static function createForTest()
    {
        $player1Hero = new Jaina();
        $player2Hero = new Jaina();

        $player1Deck = new Game\Card\Collection\Deck([]);
        $player1Hand = new Game\Card\Collection\Hand([]);
        $player1Board = new Game\Card\Collection\Board([]);

        $player2Deck = new Game\Card\Collection\Deck([]);
        $player2Hand = new Game\Card\Collection\Hand([]);
        $player2Board = new Game\Card\Collection\Board([]);

        $player1 = new \Tiixstone\Game\Player('Jonh Doe', $player1Hero, $player1Deck, $player1Hand, $player1Board);
        $player2 = new \Tiixstone\Game\Player('Agent Smith', $player2Hero, $player2Deck, $player2Hand, $player2Board);

        $eventDispatcher = new EventDispatcher();
        $gameManager = new GameManager();
        $cardsManager = new Game\Manager\CardsManager();
        $boardManager = new BoardManager();

        return new \Tiixstone\Game($player1, $player2, $eventDispatcher, $gameManager, $cardsManager, $boardManager);
    }
}