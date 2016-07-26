<?php

namespace Tiixstone\Game\Event;

use Tiixstone\Game\Card\Minion;
use Tiixstone\Game\Event;

class MinionAttackedMinion extends Event
{
    const NAME = 'minion.attacked_minion';

    /**
     * @var Minion
     */
    public $attacker;

    /**
     * @var Minion
     */
    public $target;

    public function __construct(Minion $attacker, Minion $target)
    {
        $this->attacker = $attacker;
        $this->target = $target;
    }
}