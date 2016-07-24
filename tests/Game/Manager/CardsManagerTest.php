<?php

namespace Tests\Tiixstone\Game\Manager;

use PHPUnit\Framework\TestCase;
use Tiixstone\Game\Card\Collection\Board;
use Tiixstone\Game\Card\Collection\Deck;
use Tiixstone\Game\Card\Collection\Hand;
use Tiixstone\Game\Card\Minion\Sheep;
use Tiixstone\Game\Exception;
use Tiixstone\Game\Hero\Jaina;
use Tiixstone\Game\Manager\CardsManager;
use Tiixstone\Game\Player;

class CardsManagerTest extends TestCase
{
    /**
     * @var CardsManager
     */
    public $manager;

    public function setUp()
    {
        $this->manager = new CardsManager();
    }

    public function testOverdraw()
    {
        $hero = new Jaina();

        $deck = new Deck([
            new Sheep(),
        ]);
        $hand = new Hand([
            new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(),
            new Sheep(), new Sheep(), new Sheep(), new Sheep(), new Sheep(),
        ]);
        $board = new Board();

        $player = new Player('test', $hero, $deck, $hand, $board);

        $this->manager->draw($player);

        $this->assertEquals(10, $hand->count());
    }
}