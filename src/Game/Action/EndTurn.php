<?php

namespace Tiixstone\Game\Action;

use Tiixstone\Game;
use Tiixstone\Game\Action;

class EndTurn extends Action
{
    public function process(Game $game)
    {
        $game->gameManager->endTurn($game);

        $game->eventDispatcher->dispatch(Game\Event\TurnEnded::NAME, new Game\Event\TurnEnded($game->currentPlayer()));

        $game->incrementMove();

        $game->gameManager->beginTurn($game);

        $game->eventDispatcher->dispatch(Game\Event\TurnBegan::NAME, new Game\Event\TurnBegan($game->currentPlayer()));
    }
}