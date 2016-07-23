<?php

use Tiixstone\Game\Action\PlayCard;
use Tiixstone\Game\Card\Minion\Sheep;
use Tiixstone\Game\Hero\Jaina;
use Tiixstone\Game\Player;
use Tiixstone\Game\Card\Collection\Deck;
use Tiixstone\Game\Card\Collection\Hand;
use Tiixstone\Game\Card\Collection\Board;

require_once 'vendor/autoload.php';

$player1Hero = new Jaina();
$player2Hero = new Jaina();

$player1Deck = new Deck([
    new Sheep(),
    new Sheep(),
    new Sheep(),
    new Sheep(),
    new Sheep(),
    new Sheep(),
    new Sheep(),
    new Sheep(),
    new Sheep(),
    new Sheep(),
]);
$player1Hand = new Hand([]);
$player1Board = new Board([]);

$player2Deck = new Deck([
    new Sheep(),
    new Sheep(),
    new Sheep(),
    new Sheep(),
    new Sheep(),
    new Sheep(),
    new Sheep(),
    new Sheep(),
    new Sheep(),
    new Sheep(),
]);
$player2Hand = new Hand([]);
$player2Board = new Board([]);

$player1 = new Player('Player 1', $player1Hero, $player1Deck, $player1Hand, $player1Board);
$player2 = new Player('Player 2', $player2Hero, $player2Deck, $player2Hand, $player2Board);

$gameManager = new \Tiixstone\Game\Manager\GameManager();
$cardsManager = new \Tiixstone\Game\Manager\CardsManager();

$game = new Tiixstone\Game($player1, $player2, $gameManager, $cardsManager);