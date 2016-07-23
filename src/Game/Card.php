<?php

namespace Tiixstone\Game;

abstract class Card
{
    protected $id;

    final public function __construct()
    {
        $this->id = uniqid();
    }

    /**
     * @return int
     */
    abstract public function cost() : int;

    /**
     * @return string
     */
    final public function id()
    {
        return $this->id;
    }
}