<?php

namespace Tiixstone\Game\Event;

use Tiixstone\Game\Card;
use Tiixstone\Game\Event;
use Tiixstone\Game\Player;

class CardPlayed extends Event
{
    const NAME = 'card.played';

    /**
     * @var Player
     */
    public $player;

    /**
     * @var Card
     */
    public $card;

    public function __construct(Player $player, Card $card)
    {
        $this->player = $player;
        $this->card = $card;
    }
}