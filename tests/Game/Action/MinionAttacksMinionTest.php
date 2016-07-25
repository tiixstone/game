<?php

namespace Tests\Tiixstone\Game\Action;

use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Tiixstone\Factory;
use Tiixstone\Game;
use Tiixstone\Game\Action\EndTurn;
use Tiixstone\Game\Action\MinionAttacksMinion;
use Tiixstone\Game\Card\Minion\ChillwindYeti;
use Tiixstone\Game\Card\Minion\Sheep;

class MinionAttacksMinionTest extends TestCase
{
    public function testMinionsTakeDamage()
    {
        $game = Factory::createForTest();

        $card = new Sheep();
        $game->boardManager->summonMinion($game->player1, $card);

        $targetCard = new ChillwindYeti();
        $game->boardManager->summonMinion($game->player2, $targetCard);

        $game->action(new EndTurn());
        $game->action(new EndTurn());

        $game->action(new MinionAttacksMinion($card->id(), $targetCard->id()));

        $this->assertEquals(4, $targetCard->health($game));
        $this->assertEquals(-3, $card->health($game));

        $this->assertFalse($targetCard->isDead($game));
        $this->assertTrue($card->isDead($game));
    }

    public function testMinionExhaustionAfterSummon()
    {
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::MINION_EXHAUSTED_CANT_ATTACK);

        $game = Factory::createForTest();

        $card = new Sheep();
        $game->boardManager->summonMinion($game->player1, $card);

        $targetCard = new ChillwindYeti();
        $game->boardManager->summonMinion($game->player2, $targetCard);

        $game->action(new MinionAttacksMinion($card->id(), $targetCard->id()));
    }

    public function testMinionExhaustionAfterAttack()
    {
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::MINION_EXHAUSTED_CANT_ATTACK);

        $game = Factory::createForTest();

        $sheep1 = new Sheep();
        $sheep2 = new Sheep();
        $game->boardManager->summonMinion($game->player1, $sheep1);
        $game->boardManager->summonMinion($game->player1, $sheep2);

        $yeti = new ChillwindYeti();
        $game->boardManager->summonMinion($game->player2, $yeti);

        $game->action(new EndTurn());

        $game->action(new MinionAttacksMinion($yeti->id(), $sheep1->id()));
        $game->action(new MinionAttacksMinion($yeti->id(), $sheep2->id()));
    }
}