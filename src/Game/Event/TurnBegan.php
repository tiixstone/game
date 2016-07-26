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

    /**
     * @var int
     */
    private $turnNumber;

    public function __construct(Player $player, int $turnNumber)
    {
        $this->player = $player;
        $this->turnNumber = $turnNumber;
    }

    /**
     * @return int
     */
    public function turnNumber() : int
    {
        return $this->turnNumber;
    }
}