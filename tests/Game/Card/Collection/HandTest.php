<?php

namespace Tests\Tiixstone\Game\Card\Collection;

use PHPUnit\Framework\TestCase;
use Tiixstone\Game\Card\Collection\Hand;
use Tiixstone\Game\Card\Minion\Sheep;
use Tiixstone\Game\Exception;

class HandTest extends TestCase
{
    public function testMaxCards()
    {
        $hand = new Hand([
            new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(),
            new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(),
        ]);

        $this->assertEquals(10, $hand->count());
    }

    public function testOverflowCards()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(Exception::EXCEEDED_MAX_NUMBER_CARDS_IN_HAND);

        new Hand([
            new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(),
            new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(),
            new Sheep()
        ]);
    }

    public function testOverflowCardsThruAppend()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(Exception::EXCEEDED_MAX_NUMBER_CARDS_IN_HAND);

        $hand = new Hand([
            new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(),
            new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(),
        ]);

        $hand->append(new Sheep());
    }
}