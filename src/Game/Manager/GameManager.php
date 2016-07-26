<?php declare(strict_types=1);

namespace Tiixstone\Game\Manager;

use Tiixstone\Game;
use Tiixstone\Game\Card\Minion;
use Tiixstone\Game\Event\GameStarted;
use Tiixstone\Game\Player;

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

    public function start(Game $game)
    {
        $game->eventDispatcher->dispatch(GameStarted::NAME, new GameStarted($game->currentPlayer(), $game->idlePlayer()));

        $this->shufflePlayersDeck($game);

        $this->drawCardsForPlayers($game);

        $this->beginTurn($game);

        return $this;
    }

    /**
     * @param Game $game
     * @return $this
     */
    public function afterAction(Game $game)
    {
        $this->sendDeadMinionsToGraveyard($game);

        return $this;
    }

    /**
     * @param Game $game
     * @return GameManager
     */
    public function beginTurn(Game $game)
    {
        $game->eventDispatcher->dispatch(
            Game\Event\TurnBegan::NAME, new Game\Event\TurnBegan($game->currentPlayer(), $game->turnNumber())
        );

        $this->incrementPlayerManaCrystals($game->currentPlayer());

        $game->currentPlayer()->setAvailableMana($game->currentPlayer()->manaCrystals());

        $game->cardsManager->draw($game->currentPlayer());

        $this->removeMinionsExhaustion($game);

        return $this;
    }

    /**
     * @param Game $game
     * @return GameManager
     */
    public function endTurn(Game $game) : self
    {
        $game->eventDispatcher->dispatch(
            Game\Event\TurnEnded::NAME, new Game\Event\TurnEnded($game->currentPlayer(), $game->turnNumber())
        );

        return $this;
    }

    /**
     * @return $this
     */
    private function shufflePlayersDeck(Game $game)
    {
        $game->cardsManager->shuffleDeck($game->currentPlayer());
        $game->cardsManager->shuffleDeck($game->idlePlayer());

        return $this;
    }

    /**
     * @return $this
     */
    private function drawCardsForPlayers(Game $game)
    {
        $game->cardsManager->drawMany($game->currentPlayer(), 3);
        $game->cardsManager->drawMany($game->idlePlayer(), 4);

        $game->cardsManager->appendToHand($game->idlePlayer(), new Game\Card\Spell\TheCoin());

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

    /**
     * @return $this
     */
    private function sendDeadMinionsToGraveyard(Game $game)
    {
        /** @var Player $player */
        foreach([$game->currentPlayer(), $game->idlePlayer()] as $player) {
            /** @var Minion $minion */
            foreach ($player->board->all() as $minion) {
                if ($minion->isDead($game)) {
                    $card = $player->board->pull($minion->id());

                    $card->reset();

                    $player->graveyard->append($card);
                }
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function maxManaCrystals() : int
    {
        return $this->maxManaCrystals;
    }
}