<?php

namespace Tiixstone\Game\Coin;

use Tiixstone\Game\Player;

class RandomCoin extends \Tiixstone\Game\Coin
{
    /**
     * @return $this
     */
    public function toss(Player $player1, Player $player2)
    {
        $this->winner = rand(0, 1) ? $player1 : $player2;
        $this->loser = $this->winner->id() == $player1->id() ? $player2 : $player1;

        return $this;
    }
}