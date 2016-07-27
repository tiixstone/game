<?php

namespace Tiixstone\Game\Coin;

use Tiixstone\Game\Player;

class PredictableCoin extends \Tiixstone\Game\Coin
{
    /**
     * @return $this
     */
    public function toss(Player $player1, Player $player2)
    {
        $this->winner = $player1;
        $this->loser = $player2;

        return $this;
    }
}