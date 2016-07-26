<?php

namespace Tiixstone\Game\Event;

use Tiixstone\Game\Event;
use Tiixstone\Game\Player;

class PlayerGainedMana extends Event
{
    const NAME = 'player.gained_mana';

    /**
     * @var Player
     */
    public $player;

    /**
     * @var int
     */
    private $maximum;

    /**
     * @var int
     */
    private $available;

    public function __construct(Player $player, int $maximum, int $available)
    {
        $this->player = $player;
        $this->maximum = $maximum;
        $this->available = $available;
    }

    /**
     * @return int
     */
    public function maximum() : int
    {
        return $this->maximum;
    }

    /**
     * @return int
     */
    public function available() : int
    {
        return $this->available;
    }
}