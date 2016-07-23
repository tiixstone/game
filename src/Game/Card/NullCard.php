<?php

namespace Tiixstone\Game\Card;

use Tiixstone\Game\Card;
use Tiixstone\Game\Exception;

class NullCard extends Card
{
    /**
     * @return int
     */
    public function cost() : int
    {
        throw new Exception("It is null card");
    }

    /**
     * @return Card
     */
    public function play()
    {
        throw new Exception("It is null card");
    }
}