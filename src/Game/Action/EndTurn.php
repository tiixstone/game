<?php declare(strict_types=1);

namespace Tiixstone\Game\Action;

use Tiixstone\Game;
use Tiixstone\Game\Action;

class EndTurn extends Action
{
    public function process(Game $game)
    {
        $game->gameManager->endTurn($game);

        $game->incrementMove();

        $game->gameManager->beginTurn($game);
    }
}