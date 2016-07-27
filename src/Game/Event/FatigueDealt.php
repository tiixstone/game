<?php

namespace Tiixstone\Game\Event;

use Tiixstone\Game;
use Tiixstone\Game\Card;
use Tiixstone\Game\Event;
use Tiixstone\Game\Hero;

class FatigueDealt extends Event
{
    const NAME = 'fatigue.dealt';

    /**
     * @var Game
     */
    public $game;

    /**
     * @var Hero
     */
    public $hero;

    /**
     * @var int
     */
    private $fatigue;

    public function __construct(Game $game, Hero $hero, int $fatigue)
    {
        $this->game = $game;
        $this->hero = $hero;
        $this->fatigue = $fatigue;
    }

    /**
     * @return int
     */
    public function fatigue() : int
    {
        return $this->fatigue;
    }
}