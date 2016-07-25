<?php

namespace Tiixstone\Game\Card\Minion;

use Tiixstone\Game;
use Tiixstone\Game\Card;

class DireWolfAlpha extends Card\Minion
{
    /**
     * @var array
     */
    protected $abilities = [self::ABILITY_ONGOING_EFFECT];

    /**
     * @return int
     */
    public function defaultAttackRate() : int
    {
        return 2;
    }

    /**
     * @return int
     */
    public function defaultHealth() : int
    {
        return 2;
    }

    /**
     * @return int
     */
    public function defaultCost() : int
    {
        return 2;
    }

    /**
     * @param Game $game
     */
    public function applyOngoingEffect(Game $game)
    {
        if($this->ongoingEffectApplied) {
            return;
        }

        /** @var Game\Player $player */
        foreach([$game->currentPlayer(), $game->idlePlayer()] as $player) {
            if($player->board->has($this->id())) {
                /** @var Card\Minion $leftMinion */
                if($leftMinion = $player->board->prev($this->id())) {
                    $leftMinion->setAttackRate($leftMinion->attackRate() + 1);
                }

                /** @var Card\Minion $rightMinion */
                if($rightMinion = $player->board->next($this->id())) {
                    $rightMinion->setAttackRate($rightMinion->attackRate() + 1);
                }
            }
        }

        $this->ongoingEffectApplied = true;
    }

    /**
     * @param Game $game
     */
    public function removeOngoingEffect(Game $game)
    {
        $this->attackRate = $this->attackRate - 10;
    }
}