<?php

namespace Tests\Tiixstone\Game;

use PHPUnit\Framework\TestCase;
use Tiixstone\Factory;
use Tiixstone\Game\Data;
use Tiixstone\Game\Naming;

class DataTest extends TestCase
{
    public function testAll()
    {
        $game = Factory::createForTest(Factory::createCardsArray(30), Factory::createCardsArray(30));
        $game->start();

        $dataProvider = new Data(new Naming());

        $this->assertTrue(is_array($dataProvider->all($game)));
    }
}