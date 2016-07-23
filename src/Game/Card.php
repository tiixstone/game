<?php

namespace Tiixstone\Game;

abstract class Card
{
    /**
     * @return int
     */
    abstract public function cost() : int;

    /**
     * @return Card
     */
    abstract public function play();
}