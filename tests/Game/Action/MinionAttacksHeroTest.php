<?php

namespace Tests\Tiixstone\Game\Action;

use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Tiixstone\Factory;
use Tiixstone\Game;
use Tiixstone\Game\Action\EndTurn;
use Tiixstone\Game\Action\MinionAttacksHero;
use Tiixstone\Game\Action\MinionAttacksMinion;
use Tiixstone\Game\Card\Minion\ChillwindYeti;
use Tiixstone\Game\Card\Minion\Sheep;

class MinionAttacksHeroTest extends TestCase
{
    public function testAttackerCanNotAttackIfAttackRateIsZero()
    {
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::MINION_CAN_NOT_ATTACK_ZERO_ATTACK_RATE);

        $game = Factory::createForTest();
        $game->start();

        $card = new Sheep();
        $game->boardManager->summonMinion($game->player1, $card);

        $targetCard = new ChillwindYeti();
        $targetCard->setAttackRate(0);
        $game->boardManager->summonMinion($game->player2, $targetCard);

        $game->action(new EndTurn());

        $game->action(new MinionAttacksHero($targetCard, $card));
    }

    public function testInvalidAttacker()
    {
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::INVALID_CARD);

        $game = Factory::createForTest();
        $game->start();

        $card = new Sheep();
        $game->boardManager->summonMinion($game->player1, $card);

        $targetCard = new ChillwindYeti();
        $game->boardManager->summonMinion($game->player2, $targetCard);

        $game->action(new EndTurn());

        $invalidAttacker = new Sheep();

        $game->action(new MinionAttacksHero($invalidAttacker));
    }

    public function testMinionExhaustionAfterSummon()
    {
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::MINION_EXHAUSTED_CANT_ATTACK);

        $game = Factory::createForTest();
        $game->start();

        $card = new Sheep();
        $game->boardManager->summonMinion($game->player1, $card);

        $targetCard = new ChillwindYeti();
        $game->boardManager->summonMinion($game->player2, $targetCard);

        $game->action(new MinionAttacksHero($card, $targetCard));
    }

    public function testMinionExhaustionAfterAttack()
    {
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::MINION_EXHAUSTED_CANT_ATTACK);

        $game = Factory::createForTest();
        $game->start();

        $yeti = new ChillwindYeti();
        $game->boardManager->summonMinion($game->player2, $yeti);

        $game->action(new EndTurn());

        $game->action(new MinionAttacksHero($yeti, $yeti));
        $game->action(new MinionAttacksHero($yeti, $yeti));
    }
}