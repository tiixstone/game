<?php

namespace Tests\Tiixstone\Game\Manager;

use PHPUnit\Framework\TestCase;
use Tiixstone\Factory;
use Tiixstone\Game\Action\EndTurn;
use Tiixstone\Game\Action\PlayCard;
use Tiixstone\Game\Card\Minion\ChillwindYeti;
use Tiixstone\Game\Card\Minion\Sheep;

class BoardManagerTest extends TestCase
{
    public function testPlaceCardOnBoard()
    {
        $game = Factory::createForTest(Factory::createCardsArray(30), Factory::createCardsArray(30));
        $game->start();
        $this->assertEquals(0, $game->currentPlayer()->board->count());

        $game->action(new PlayCard($game->currentPlayer()->hand->first()));
        $this->assertEquals(1, $game->currentPlayer()->board->count());
    }

    public function testPlaceCardOnSpecificPosition()
    {
        $game = Factory::createForTest(
            Factory::createCardsArray(30), Factory::createCardsArray(30),
            [], [],
            [new Sheep(), new Sheep()], []
        );
        $game->start();
        $this->assertEquals(2, $game->currentPlayer()->board->count());
        $this->assertEquals(4, $game->currentPlayer()->hand->count());

        $game->action(new EndTurn());
        $game->action(new EndTurn());

        // place to left position
        $playedCard = $game->currentPlayer()->hand->first();
        $game->action(new PlayCard($playedCard, $game->currentPlayer()->board->first()));
        $this->assertEquals(3, $game->currentPlayer()->board->count());
        $this->assertEquals(4, $game->currentPlayer()->hand->count());
        $this->assertEquals($playedCard->id(), $game->currentPlayer()->board->first()->id());

        // place to right position
        $playedCard = $game->currentPlayer()->hand->first();
        $game->action(new PlayCard($playedCard));
        $this->assertEquals(4, $game->currentPlayer()->board->count());
        $this->assertEquals($playedCard->id(), $game->currentPlayer()->board->last()->id());

        $game->action(new EndTurn());
        $game->action(new EndTurn());
        
        // place in the middle
        $playedCard = $game->currentPlayer()->hand->first();
        $game->action(new PlayCard($playedCard, $game->currentPlayer()->board->getByPosition(3)));
        $this->assertEquals(5, $game->currentPlayer()->board->count());
        $this->assertEquals($playedCard->id(), $game->currentPlayer()->board->getByPosition(3)->id());
    }

    public function testSummonMinion()
    {
        $game = Factory::createForTest();
        $game->start();

        $minion = new Sheep();
        $game->boardManager->summonMinion($game->currentPlayer(), $minion);

        $this->assertEquals($minion->id(), $game->currentPlayer()->board->first()->id());
    }

    public function testVacantPlaces()
    {
        $game = Factory::createForTest();
        $game->start();
        $this->assertTrue($game->boardManager->hasVacantPlace($game->currentPlayer()));

        $game->currentPlayer()->board->appendMany([new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep()]);
        $this->assertFalse($game->boardManager->hasVacantPlace($game->currentPlayer()));
    }
}