<?php

namespace Tiixstone\Game\Event;

use Tiixstone\Game\Event;
use Tiixstone\Game\Player;

class TurnEnded extends Event
{
    const NAME = 'turn.ended';

    /**
     * @var Player
     */
    public $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }
}