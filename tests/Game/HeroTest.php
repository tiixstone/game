<?php

namespace Tests\Tiixstone\Game;

use Tiixstone\Game\Exception;
use Tiixstone\Game\Hero\Jaina;

class HeroTest extends \PHPUnit\Framework\TestCase
{
    public function testIsAlive()
    {
        $jaina = new Jaina();
        $this->assertTrue($jaina->isAlive());

        $jaina->setHealth(0);
        $this->assertFalse($jaina->isAlive());

        $jaina->setHealth(-10);
        $this->assertFalse($jaina->isAlive());

        $jaina->setHealth(10);
        $this->assertTrue($jaina->isAlive());
    }

    public function testOverheal()
    {
        $jaina = new Jaina();
        $this->assertEquals(30, $jaina->health());

        $jaina->addHealth(10);
        $this->assertEquals(30, $jaina->health());

        $this->expectException(Exception::class);

        $jaina->setHealth(40);
        $this->assertEquals(30, $jaina->health());
    }

    public function testHealthManipulation()
    {
        $jaina = new Jaina();
        $this->assertEquals(30, $jaina->health());

        $jaina->setHealth(15);
        $this->assertEquals(15, $jaina->health());

        $jaina->reduceHealth(5);
        $this->assertEquals(10, $jaina->health());

        $jaina->addHealth(10);
        $this->assertEquals(20, $jaina->health());

        $jaina->reduceHealth(2);
        $this->assertEquals(18, $jaina->health());
    }
}