<?php

namespace Tiixstone\Game\Manager;

use Tiixstone\Game;

class BoardManager
{
    /**
     * @var int
     */
    protected $maxPlacesOnBoard = 7;
    
    /**
     * @return bool
     */
    public function hasVacantPlace(Game\Player $player)
    {
        return $player->board->count() < $this->maxPlacesOnBoard();
    }

    /**
     * @return int
     */
    public function maxPlacesOnBoard() : int
    {
        return $this->maxPlacesOnBoard;
    }
}