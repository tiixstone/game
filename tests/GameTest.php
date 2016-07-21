<?php

class GameTest extends \PHPUnit\Framework\TestCase
{
    public function testGameIsOn()
    {
        $game = new \Tiixstone\Game();

        $this->assertTrue(is_object($game));
    }
}