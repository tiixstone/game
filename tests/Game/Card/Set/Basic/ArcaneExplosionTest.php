<?php

namespace Tests\Tiixstone\Game\Card\Spell;

use PHPUnit\Framework\TestCase;
use Tiixstone\Factory;
use Tiixstone\Game;

class ArcaneExplosionTest extends TestCase
{
    public function testAddMana()
    {
        $game = Factory::createForTest(
            Factory::createCardsArray(30, Game\Card\Set\Basic\ChillwindYeti::class),
            Factory::createCardsArray(30, Game\Card\Set\Basic\ChillwindYeti::class)
        );

        $game->start();

        $game->boardManager->summonMinion($game->idlePlayer(), new Game\Card\Set\Basic\ChillwindYeti());
        $game->boardManager->summonMinion($game->idlePlayer(), new Game\Card\Set\Basic\ChillwindYeti());
        $game->boardManager->summonMinion($game->idlePlayer(), new Game\Card\Set\Basic\ChillwindYeti());
        $game->boardManager->summonMinion($game->idlePlayer(), new Game\Card\Set\Basic\ChillwindYeti());

        /** @var Game\Card\Minion $minion */
        foreach($game->idlePlayer()->board->all() as $minion) {
            $this->assertEquals(5, $minion->health($game));
        }
        
        $game->cardsManager->appendToHand($game->currentPlayer(), new Game\Card\Set\Basic\ArcaneExplosion());
        $game->gameManager->addPlayerAvailableMana($game, $game->currentPlayer(), 10);

        $game->action(new Game\Action\PlayCard($game->currentPlayer()->hand->last()));

        /** @var Game\Card\Minion $minion */
        foreach($game->currentPlayer()->board->all() as $minion) {
            $this->assertEquals(4, $minion->health($game));
        }
    }
}