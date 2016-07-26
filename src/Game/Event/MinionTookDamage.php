<?php

namespace Tiixstone\Game\Event;

use Tiixstone\Game\Card\Minion;
use Tiixstone\Game\Event;

class MinionTookDamage extends Event
{
    const NAME = 'minion.took_damage';

    /**
     * @var Minion
     */
    public $minion;

    /**
     * @var int
     */
    private $damage;

    public function __construct(Minion $minion, int $damage)
    {
        $this->minion = $minion;
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