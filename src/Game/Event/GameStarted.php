<?php

namespace Tiixstone\Game\Event;

use Tiixstone\Game\Event;
use Tiixstone\Game\Player;

class GameStarted extends Event
{
    const NAME = 'game.started';

    /**
     * @var Player
     */
    public $currentPlayer;

    /**
     * @var Player
     */
    public $idlePlayer;

    public function __construct(Player $currentPlayer, Player $idlePlayer)
    {
        $this->currentPlayer = $currentPlayer;
        $this->idlePlayer = $idlePlayer;
    }
}