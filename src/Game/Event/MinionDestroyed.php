<?php

namespace Tiixstone\Game\Event;

use Tiixstone\Game\Card\Minion;
use Tiixstone\Game\Event;

class MinionDestroyed extends Event
{
    const NAME = 'minion.destroyed';

    /**
     * @var Minion
     */
    public $minion;

    public function __construct(Minion $minion)
    {
        $this->minion = $minion;
    }
}