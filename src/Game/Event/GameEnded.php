<?php

namespace Tiixstone\Game\Event;

use Tiixstone\Game\Event;
use Tiixstone\Game\Player;

class GameEnded extends Event
{
    const NAME = 'game.ended';

    /**
     * @var Player
     */
    public $winner;

    /**
     * @var Player
     */
    public $loser;

    public function __construct(Player $winner = null, Player $loser = null)
    {
        $this->winner = $winner;
        $this->loser = $loser;
    }
}