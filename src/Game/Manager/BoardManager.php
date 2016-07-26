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
     * @param Game\Card\Minion|null $rightMinion
     * @return $this
     * @throws Game\Exception
     */
    public function placeCardOnBoard(Game\Player $player, Game\Card\Minion $card, Game\Card\Minion $rightMinion = null)
    {
        if(!$this->hasVacantPlace($player)) {
            throw new Game\Exception("There is no vacant place on board", Game\Exception::EXCEEDED_PLACES_ON_BOARD);
        }

        // Существо ставится на поле относительно другого существа,
        // которое находится справа
        // Если поле не пустое и не указано существо, значит
        // существо надо поставить в крайнюю правую позицию
        if($player->board->isEmpty() OR !$rightMinion) {
            $player->board->append($card);
        } else {
           $player->board->addBefore($card, $rightMinion->id());
        }

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