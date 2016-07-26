<?php declare(strict_types=1);

namespace Tiixstone\Game\Action;

use Tiixstone\Game;
use Tiixstone\Game\Action;

class MinionAttacksMinion extends Action
{
    /**
     * @var Game\Card\Minion
     */
    private $attacker;

    /**
     * @var Game\Card\Minion
     */
    private $target;

    public function __construct(Game\Card\Minion $attacker, Game\Card\Minion $target)
    {
        $this->attacker = $attacker;
        $this->target = $target;
    }

    public function process(Game $game)
    {
        /** @var $exception Game\Exception */
        if(($exception = $this->canAttack($game, true)) !== true) {
            throw $exception;
        }

        $game->eventDispatcher->dispatch(
            Game\Event\MinionAttackedMinion::NAME,
            new Game\Event\MinionAttackedMinion($this->attacker, $this->target)
        );

        $game->attackManager->minionTakeDamage($game, $this->target, $this->attacker->attackRate($game));
        $game->attackManager->minionTakeDamage($game, $this->attacker, $this->target->attackRate($game));

        $this->attacker->setExhausted(true);
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
                throw new Game\Exception("Card does not exist", Game\Exception::INVALID_CARD);
            } else {
                return false;
            }
        }

        if(!$this->targetCardExists($game)) {
            if($throwException) {
                throw new Game\Exception("Card does not exist", Game\Exception::INVALID_CARD);
            } else {
                return false;
            }
        }

        if(!$this->attackRateGreaterThanZero($game)) {
            if($throwException) {
                throw new Game\Exception("Minion can not attack. Attack rate is zero", Game\Exception::MINION_CAN_NOT_ATTACK_ZERO_ATTACK_RATE);
            } else {
                return false;
            }
        }

        if($this->attacker->isExhausted()) {
            if($throwException) {
                throw new Game\Exception("Minion can not attack. It is exhausted", Game\Exception::MINION_EXHAUSTED_CANT_ATTACK);
            } else {
                return false;
            }
        }
        
        if(!$this->attacker->attackCondition($game)) {
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
     */
    protected function attackRateGreaterThanZero(Game $game) : bool
    {
        return $this->attacker->attackRate($game) > 0;
    }

    /**
     * @param Game $game
     * @return bool
     */
    protected function targetCardExists(Game $game) : bool
    {
        return $game->idlePlayer()->board->has($this->target->id());
    }

    /**
     * @param Game $game
     * @return bool
     */
    protected function cardExists(Game $game) : bool
    {
        return $game->currentPlayer()->board->has($this->attacker->id());
    }
}