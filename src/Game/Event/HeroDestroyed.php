<?php

namespace Tiixstone\Game\Event;

use Tiixstone\Game;
use Tiixstone\Game\Card\Minion;
use Tiixstone\Game\Event;
use Tiixstone\Game\Hero;

class HeroDestroyed extends Event
{
    const NAME = 'hero.destroyed';

    /**
     * @var Game
     */
    public $game;

    /**
     * @var Hero
     */
    public $hero;

    public function __construct(Game $game, Hero $hero)
    {
        $this->game = $game;
        $this->hero = $hero;
    }
}