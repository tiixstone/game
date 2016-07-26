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
    public function testHeroTakesDamage()
    {
        $game = Factory::createForTest(Factory::createCardsArray(30), Factory::createCardsArray(30));
        $this->assertEquals(30, $game->idlePlayer()->hero->health());

        $game->action(new Game\Action\PlayCard($game->currentPlayer()->hand->first()));
        $game->action(new EndTurn());
        $game->action(new EndTurn());

        $game->action(new Game\Action\MinionAttacksHero($game->currentPlayer()->board->first()));
        $this->assertEquals(29, $game->idlePlayer()->hero->health());
    }

    public function testAttackerCanNotAttackIfAttackRateIsZero()
    {
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::MINION_CAN_NOT_ATTACK_ZERO_ATTACK_RATE);

        $game = Factory::createForTest();

        $card = new Sheep();
        $game->boardManager->summonMinion($game->player1, $card);

        $targetCard = new ChillwindYeti();
        $targetCard->setAttackRate(0);
        $game->boardManager->summonMinion($game->player2, $targetCard);

        $game->action(new EndTurn());

        $game->action(new MinionAttacksMinion($targetCard, $card));
    }

    public function testInvalidAttacker()
    {
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::INVALID_CARD);

        $game = Factory::createForTest();

        $card = new Sheep();
        $game->boardManager->summonMinion($game->player1, $card);

        $targetCard = new ChillwindYeti();
        $game->boardManager->summonMinion($game->player2, $targetCard);

        $game->action(new EndTurn());

        $invalidAttacker = new Sheep();

        $game->action(new MinionAttacksMinion($invalidAttacker, $card));
    }

    public function testInvalidTarget()
    {
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::INVALID_CARD);

        $game = Factory::createForTest();

        $sheep = new Sheep();
        $game->boardManager->summonMinion($game->player1, $sheep);

        $yeti = new ChillwindYeti();
        $game->boardManager->summonMinion($game->player2, $yeti);

        $game->action(new EndTurn());

        $invalidTarget = new Sheep();

        $game->action(new MinionAttacksMinion($yeti, $invalidTarget));
    }

    public function testMinionsTakeDamage()
    {
        $game = Factory::createForTest();

        $card = new Sheep();
        $game->boardManager->summonMinion($game->player1, $card);

        $targetCard = new ChillwindYeti();
        $game->boardManager->summonMinion($game->player2, $targetCard);

        $game->action(new EndTurn());
        $game->action(new EndTurn());

        $game->action(new MinionAttacksMinion($card, $targetCard));

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

        $game->action(new MinionAttacksMinion($card, $targetCard));
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

        $game->action(new MinionAttacksMinion($yeti, $sheep1));
        $game->action(new MinionAttacksMinion($yeti, $sheep2));
    }
}