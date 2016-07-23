<?php

namespace Tests\Tiixstone\Game\Card\Collection;

use PHPUnit\Framework\TestCase;
use Tiixstone\Game\Card\Collection\Board;
use Tiixstone\Game\Card\Collection\Hand;
use Tiixstone\Game\Card\Minion\Sheep;
use Tiixstone\Game\Exception;

class BoardTest extends TestCase
{
    public function testMaxCards()
    {
        $hand = new Board([
            new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(),
        ]);

        $this->assertEquals(7, $hand->count());
    }

    public function testOverflowCards()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(Exception::EXCEEDED_PLACES_ON_BOARD);

        new Board([
            new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(),
            new Sheep()
        ]);
    }

    public function testOverflowCardsThruAppend()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(Exception::EXCEEDED_PLACES_ON_BOARD);

        $board = new Board([
            new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(),
        ]);

        $board->append(new Sheep());
    }

    public function testHasVacantPlace()
    {
        $board = new Board();
        $this->assertTrue($board->hasVacantPlace());

        $board->appendMany([new Sheep(), new Sheep()]);
    }
}