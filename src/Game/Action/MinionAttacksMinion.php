<?php declare(strict_types=1);

namespace Tiixstone\Game\Action;

use Tiixstone\Game;
use Tiixstone\Game\Action;

class MinionAttacksMinion extends Action
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $targetId;

    public function __construct(string $id, string $targetId)
    {
        $this->id = $id;
        $this->targetId = $targetId;
    }

    public function process(Game $game)
    {
        /** @var $exception Game\Exception */
        if(($exception = $this->canAttack($game, true)) !== true) {
            throw $exception;
        }

        /** @var Game\Card\Minion $card */
        $card = $game->currentPlayer()->board->get($this->id);
        /** @var Game\Card\Minion $targetCard */
        $targetCard = $game->idlePlayer()->board->get($this->targetId);

        $game->attackManager->minionTakeDamage($game, $targetCard, $card->attackRate($game));
        $game->attackManager->minionTakeDamage($game, $card, $targetCard->attackRate($game));

        $card->setExhausted(true);
    }

    /**
     * @param Game $game
     * @param bool $throwException
     * @return bool
     */
    public function canAttack(Game $game, $throwException = false)
    {
        if(!$this->cardExists($game)) {
            if($throwException) {
                throw new Game\Exception("Card does not exist");
            } else {
                return false;
            }
        }

        if(!$this->targetCardExists($game)) {
            if($throwException) {
                throw new Game\Exception("Card does not exist");
            } else {
                return false;
            }
        }

        if(!$this->attackRateGreaterThanZero($game)) {
            if($throwException) {
                throw new Game\Exception("Minion can not attack. Attack rate is zero");
            } else {
                return false;
            }
        }

        if($this->minionExhausted($game)) {
            if($throwException) {
                throw new Game\Exception("Minion can not attack. It is exhausted", Game\Exception::MINION_EXHAUSTED_CANT_ATTACK);
            } else {
                return false;
            }
        }

        /** @var Game\Card\Minion $minion */
        $minion = $game->currentPlayer()->board->get($this->id);

        if(!$minion->attackCondition($game)) {
            if($throwException) {
                throw new Game\Exception("Minion can not attack. Conditions are not fulfilled");
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Game $game
     * @return bool
     * @throws Game\Exception
     */
    protected function minionExhausted(Game $game) : bool
    {
        /** @var Game\Card\Minion $minion */
        $minion = $game->currentPlayer()->board->get($this->id);

        return $minion->isExhausted();
    }

    protected function attackRateGreaterThanZero(Game $game) : bool
    {
        /** @var Game\Card\Minion $minion */
        $minion = $game->currentPlayer()->board->get($this->id);

        return $minion->attackRate($game) > 0;
    }

    /**
     * @param Game $game
     * @return bool
     */
    protected function targetCardExists(Game $game) : bool
    {
        return $game->idlePlayer()->board->has($this->targetId);
    }

    /**
     * @param Game $game
     * @return bool
     */
    protected function cardExists(Game $game) : bool
    {
        return $game->currentPlayer()->board->has($this->id);
    }
}