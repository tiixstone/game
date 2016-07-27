<?php declare(strict_types=1);

namespace Tiixstone\Game\Manager;

use Tiixstone\Game;
use Tiixstone\Game\Card\Minion;
use Tiixstone\Game\Card\Set\Basic\TheCoin;
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
    protected $playerMaximumManaLimit = 10;

    /**
     * @var Game\Coin
     */
    public $coin;

    public function __construct(Game\Coin $coin)
    {
        $this->coin = $coin;
    }

    public function start(Game $game)
    {
        $this->tossCoin($game);

        $game->eventDispatcher->dispatch(GameStarted::NAME, new GameStarted($game->currentPlayer(), $game->idlePlayer()));

        $this->shufflePlayersDeck($game);

        $this->drawCardsForPlayers($game);

        $this->beginTurn($game);

        return $this;
    }

    /**
     * @param Game $game
     * @return $this
     * @throws Game\Exception
     */
    private function tossCoin(Game $game)
    {
        $this->coin->toss($game->player1, $game->player2);

        $game->firstToGoPlayer = $this->coin->winner();
        $game->secondToGoPlayer = $this->coin->loser();

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

        $this->addPlayerMaximumMana($game, $game->currentPlayer(), 1);
        $this->setPlayerAvailableMana($game, $game->currentPlayer(), $game->currentPlayer()->maximumMana());

        $game->cardsManager->draw($game, $game->currentPlayer());

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
        $game->cardsManager->drawMany($game, $game->currentPlayer(), 3);
        $game->cardsManager->drawMany($game, $game->idlePlayer(), 4);

        $game->cardsManager->appendToHand($game->idlePlayer(), new TheCoin());

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
     * @param Player $player
     * @param int $amount
     * @return $this
     * @throws Game\Exception
     */
    public function setPlayerAvailableMana(Game $game, Player $player, int $amount)
    {
        if($amount < 0) {
            throw new Game\Exception("Available mana must be zero or greater than zero");
        }

        if($amount > $this->playerMaximumManaLimit()) {
            $amount = $this->playerMaximumManaLimit();
        }

        $gainedAvailableMana = $amount - $player->availableMana();

        $player->setAvailableMana($amount);

        $game->eventDispatcher->dispatch(Game\Event\PlayerGainedMana::NAME, new Game\Event\PlayerGainedMana($player, 0, $gainedAvailableMana));

        return $this;
    }

    /**
     * @param Player $player
     * @param int $amount
     * @return GameManager
     * @throws Game\Exception
     */
    public function addPlayerAvailableMana(Game $game, Player $player, int $amount)
    {
        return $this->setPlayerAvailableMana($game, $player, $player->availableMana() + $amount);
    }

    /**
     * @param Player $player
     * @param int $amount
     * @return GameManager
     * @throws Game\Exception
     */
    public function reducePlayerAvailableMana(Game $game, Player $player, int $amount)
    {
        return $this->setPlayerAvailableMana($game, $player, $player->availableMana() - $amount);
    }

    /**
     * @param Player $player
     * @param int $maximumMana
     * @return $this
     */
    public function setPlayerMaximumMana(Game $game, Player $player, int $maximumMana)
    {
        if($maximumMana < 0) {
            throw new Game\Exception("Maximum mana must be zero or greater than zero");
        }

        if($maximumMana > $this->playerMaximumManaLimit()) {
            $maximumMana = $this->playerMaximumManaLimit();
        }

        $gainedMaximumMana = $maximumMana - $player->maximumMana();

        $player->setMaximumMana($maximumMana);

        $game->eventDispatcher->dispatch(Game\Event\PlayerGainedMana::NAME, new Game\Event\PlayerGainedMana($player, $gainedMaximumMana, 0));

        return $this;
    }

    /**
     * @param Player $player
     * @param int $amount
     * @return GameManager
     */
    public function addPlayerMaximumMana(Game $game, Player $player, int $amount)
    {
        return $this->setPlayerMaximumMana($game, $player, $player->maximumMana() + $amount);
    }

    /**
     * @param Player $player
     * @param int $amount
     * @return GameManager
     */
    public function reducePlayerMaximumMana(Game $game, Player $player, int $amount)
    {
        return $this->setPlayerMaximumMana($game, $player, $player->maximumMana() - $amount);
    }

    /**
     * @return int
     */
    public function playerMaximumManaLimit() : int
    {
        return $this->playerMaximumManaLimit;
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
                    $game->attackManager->destroyMinion($game, $player, $minion);
                }
            }
        }

        return $this;
    }

    /**
     * @param Game $game
     * @return $this
     */
    public function end(Game $game)
    {
        $game->eventDispatcher->dispatch(
            Game\Event\GameEnded::NAME,
            new Game\Event\GameEnded($game->winner(), $game->loser())
        );
        
        return $this;
    }
}