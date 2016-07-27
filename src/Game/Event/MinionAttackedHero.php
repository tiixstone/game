<?php

namespace Tiixstone\Game\Event;

use Tiixstone\Game\Card\Minion;
use Tiixstone\Game\Event;
use Tiixstone\Game\Hero;

class MinionAttackedHero extends Event
{
    const NAME = 'minion.attacked_hero';

    /**
     * @var Minion
     */
    public $attacker;

    /**
     * @var Minion
     */
    public $target;

    /**
     * @var Minion
     */
    public $hero;

    /**
     * @var int
     */
    private $damage;

    public function __construct(Minion $attacker, Hero $hero, int $damage)
    {
        $this->attacker = $attacker;
        $this->hero = $hero;
        $this->damage = $damage;
    }

    /**
     * @return int
     */
    public function damage() : int
    {
        return $this->damage;
    }
}