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
    const MAX_MANA_CRYSTALS = 10;

    /**
     * @param Game $game
     * @return $this
     */
    public function start(Game $game)
    {
        $this->shufflePlayersDeck($game);

        $this->drawCardsForPlayers($game);

        return $this;
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

    /**
     * @return Game
     */
    protected function shufflePlayersDeck(Game $game) : self
    {
        $game->cardsManager->shuffleDeck($game->currentPlayer());
        $game->cardsManager->shuffleDeck($game->idlePlayer());

        return $this;
    }

    /**
     * @param $game
     * @return GameManager
     */
    private function drawCardsForPlayers(Game $game) : self
    {
        $game->cardsManager->drawMany($game->currentPlayer(), 3);
        $game->cardsManager->drawMany($game->idlePlayer(), 4);

        $game->cardsManager->appendToHand($game->idlePlayer(), new Game\Card\Spell\TheCoin());

        return $this;
    }

    /**
     * @return int
     */
    protected function maxManaCrystals() : int
    {
        return self::MAX_MANA_CRYSTALS;
    }
}