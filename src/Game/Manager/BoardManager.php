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
     * @param Game\Player $player
     * @param Game\Card\Minion $minion
     * @return $this
     */
    public function summonMinion(Game\Player $player, Game\Card\Minion $minion)
    {
        if($this->hasVacantPlace($player)) {
            $player->board->append($minion);
        }

        return $this;
    }

    /**
     * @param Game\Player $player
     * @param Game\Card\Minion $card
     * @return $this
     */
    public function placeCardOnBoard(Game\Player $player, Game\Card\Minion $card)
    {
        if(!$this->hasVacantPlace($player)) {
            throw new Game\Exception("There is no vacant place on board", Game\Exception::EXCEEDED_PLACES_ON_BOARD);
        }

        $player->board->append($card);

        return $this;
    }

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