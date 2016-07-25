<?php declare(strict_types=1);

namespace Tiixstone\Game\Manager;

use Tiixstone\Game;

/**
 * Class GameManager
 *
 * @package Tiixstone\Game\Mode
 */
class GameManager
{
    /**
     * @var int
     */
    protected $maxManaCrystals = 10;

    /**
     * @return int
     */
    public function maxManaCrystals() : int
    {
        return $this->maxManaCrystals;
    }

    /**
     * @param Game $game
     * @return GameManager
     */
    public function beginTurn(Game $game) : self
    {
        $this->incrementPlayerManaCrystals($game->currentPlayer());

        $game->currentPlayer()->setAvailableMana($game->currentPlayer()->manaCrystals());

        $game->cardsManager->draw($game->currentPlayer());

        $this->removeMinionsExhaustion($game);

        return $this;
    }

    private function removeMinionsExhaustion(Game $game)
    {
        /** @var Game\Card\Minion $minion */
        foreach($game->currentPlayer()->board->all() as $minion) {
            $minion->setExhausted(false);
        }

        return $this;
    }

    /**
     * @param Game $game
     * @return GameManager
     */
    public function endTurn(Game $game) : self
    {
        return $this;
    }

    /**
     * @param Game\Player $player
     * @param int $amount
     * @return $this
     */
    public function incrementPlayerMana(Game\Player $player, int $amount = 1)
    {
        if($player->availableMana() < $this->maxManaCrystals()) {
            $player->setAvailableMana($player->availableMana() + $amount);
        }

        return $this;
    }

    /**
     * @param Game\Player $player
     * @return GameManager
     */
    public function incrementPlayerManaCrystals(Game\Player $player) : self
    {
        if($player->manaCrystals() < $this->maxManaCrystals()) {
            $player->incrementManaCrystals();
        }

        return $this;
    }

    /**
     * @param Game $game
     * @param int $amount
     * @return $this
     * @throws Game\Exception
     */
    public function reducePlayerMana(Game\Player $player, int $amount) : self
    {
        if($player->availableMana() < $amount) {
            throw new Game\Exception(
                sprintf("Player does not have enough mana"),
                Game\Exception::PLAYER_DOESNT_HAVE_ENOUGH_MANA_TO_PLAY_CARD
            );
        }

        $player->reduceAvailableMana($amount);

        return $this;
    }
}