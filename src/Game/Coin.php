<?php

namespace Tiixstone\Game;

abstract class Coin
{
    /**
     * @var Player
     */
    protected $winner;

    /**
     * @var Player
     */
    protected $loser;
    /**
     * @return mixed
     */
    abstract public function toss(Player $player1, Player $player2);

    /**
     * @return Player
     */
    public function winner()
    {
        if(!$this->winner) {
            throw new Exception("Method `toss` should be called first");
        }

        return $this->winner;
    }

    /**
     * @return Player
     */
    public function loser()
    {
        if(!$this->loser) {
            throw new Exception("Method `toss` should be called first");
        }

        return $this->loser;
    }
}