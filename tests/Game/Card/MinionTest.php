<?php

namespace Tests\Tiixstone\Game;

use PHPUnit\Framework\TestCase;
use Tiixstone\Factory;
use Tiixstone\Game;
use Tiixstone\Game\Card\Minion;

class MinionTest extends TestCase
{
    public function testStats()
    {
        $game = Factory::createForTest();

        $minion = new GenericMinion();

        $this->assertEquals(10, $minion->cost($game));
        $this->assertEquals(10, $minion->health($game));
        $this->assertEquals(10, $minion->attackRate($game));
    }

    public function testSpecialStats()
    {
        $game = Factory::createForTest();

        $minion = new SpecialMinion();

        $this->assertEquals(1, $minion->cost($game));
        $this->assertEquals(1, $minion->health($game));
        $this->assertEquals(1, $minion->attackRate($game));
    }

    public function testMinionExhausted()
    {
        $minion = new GenericMinion();
        $this->assertTrue($minion->isExhausted());

        $minion->setExhausted(false);
        $this->assertFalse($minion->isExhausted());
    }

    public function testDead()
    {
        $game = Factory::createForTest();

        $minion = new GenericMinion();
        $this->assertFalse($minion->isDead($game));

        $minion->setHealth(0);
        $this->assertTrue($minion->isDead($game));

        $minion->setHealth(-10);
        $this->assertTrue($minion->isDead($game));
    }
}

class SpecialMinion extends Minion
{
    /**
     * @param Game $game
     * @return int
     */
    public function cost(Game $game) : int
    {
        return 1;
    }

    /**
     * @param Game $game
     * @return int
     */
    public function health(Game $game) : int
    {
        return 1;
    }

    /**
     * @param Game $game
     * @return int
     */
    public function attackRate(Game $game) : int
    {
        return 1;
    }

    /**
     * @return int
     */
    public function defaultCost() : int
    {
        return 10;
    }

    /**
     * @return int
     */
    public function defaultHealth() : int
    {
        return 10;
    }

    /**
     * @return int
     */
    public function defaultAttackRate() : int
    {
        return 10;
    }
}

class GenericMinion extends Minion
{
    /**
     * @return int
     */
    public function defaultCost() : int
    {
        return 10;
    }

    /**
     * @return int
     */
    public function defaultHealth() : int
    {
        return 10;
    }

    /**
     * @return int
     */
    public function defaultAttackRate() : int
    {
        return 10;
    }
}