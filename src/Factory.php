<?php

namespace Tiixstone;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Tiixstone\Game\Card\Minion\Sheep;
use Tiixstone\Game\Hero\Jaina;
use Tiixstone\Game\Manager\AttackManager;
use Tiixstone\Game\Manager\BoardManager;
use Tiixstone\Game\Manager\GameManager;
use Tiixstone\Game\Manager\StatsManager;

class Factory
{
    public static function createForTest(
        $player1Deck = [],
        $player2Deck = [],
        $player1Hand = [],
        $player2Hand = [],
        $player1Board = [],
        $player2Board = []
    )
    {
        $player1Hero = new Jaina();
        $player2Hero = new Jaina();

        $player1Deck = new Game\Card\Collection\Deck($player1Deck);
        $player1Hand = new Game\Card\Collection\Hand($player1Hand);
        $player1Board = new Game\Card\Collection\Board($player1Board);

        $player2Deck = new Game\Card\Collection\Deck($player2Deck);
        $player2Hand = new Game\Card\Collection\Hand($player2Hand);
        $player2Board = new Game\Card\Collection\Board($player2Board);

        $player1 = new \Tiixstone\Game\Player('Jonh Doe', $player1Hero, $player1Deck, $player1Hand, $player1Board);
        $player2 = new \Tiixstone\Game\Player('Agent Smith', $player2Hero, $player2Deck, $player2Hand, $player2Board);

        $eventDispatcher = new EventDispatcher();
        $gameManager = new GameManager();
        $cardsManager = new Game\Manager\CardsManager();
        $boardManager = new BoardManager();
        $attackManager = new AttackManager();

        return new \Tiixstone\Game($player1, $player2, $eventDispatcher, $gameManager, $cardsManager, $boardManager, $attackManager);
    }

    public static function createCardsArray(int $amount, $card = null)
    {
        if(!$card) {
            $card = Sheep::class;
        }

        $cards = [];

        for($i=0; $i<$amount; $i++) {
            $cards[] = new $card;
        }

        return $cards;
    }
}