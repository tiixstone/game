<?php

namespace Tiixstone\Game\Event;

use Tiixstone\Game\Event;
use Tiixstone\Game\Player;

class TurnBegan extends Event
{
    const NAME = 'turn.began';

    /**
     * @var Player
     */
    public $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }
}