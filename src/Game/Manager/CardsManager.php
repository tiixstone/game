<?php declare(strict_types=1);

namespace Tiixstone\Game\Manager;

use Tiixstone\Game;
use Tiixstone\Game\Card\NullCard;

/**
 * Class CardsManager
 *
 * Управляет перемещением карт и т.п.
 *
 * @package Tiixstone\Game\Manager
 */
class CardsManager
{
    /**
     * Получаем карту из руки
     *
     * @param Game\Player $player
     * @param int $key
     * @return Game\Card
     * @throws Game\Exception
     */
    public function getCardFromHand(Game\Player $player, int $key)
    {
        if(!$player->hand->has($key)) {
            throw new Game\Exception(
                sprintf("Player does not have card with key [%s]", $key),
                Game\Exception::PLAYER_DOESNT_HAVE_CARD_IN_HAND_WITH_REQUIRED_KEY
            );
        }
        
        return $player->hand->pull($key);
    }
    
    /**
     * Перекладываем карту из колоды в руку игрока
     *
     * @param Game\Player $player
     * @return $this
     * @throws Game\Exception
     */
    public function draw(Game\Player $player) : self
    {
        $card = $this->getCardFromDeck($player);

        if(!($card instanceof NullCard)) {
            $this->appendToHand($player, $card);
        }

        return $this;
    }

    /**
     * @param Game\Player $player
     * @param int $amount
     * @return $this
     */
    public function drawMany(Game\Player $player, int $amount = 1) : self
    {
        for ($i = 0; $i < $amount; $i++) {
            $this->draw($player);
        }

        return $this;
    }

    /**
     * @param Game\Player $player
     * @return Game\Card
     * @throws Game\Exception
     */
    public function getCardFromDeck(Game\Player $player) : Game\Card
    {
        if($player->deck->count()) {
            return $player->deck->shift();
        }

        $player->hero->reduceHealth($player->fatigue());
        $player->incrementFatigue();

        return new NullCard();
    }

    /**
     * @param Game\Player $player
     * @return CardsManager
     */
    public function shuffleDeck(Game\Player $player) : self
    {
        $player->deck->shuffle();

        return $this;
    }

    /**
     * @param Game\Player $player
     * @param Game\Card $card
     * @return CardsManager
     */
    public function appendToHand(Game\Player $player, Game\Card $card) : self
    {
        $player->hand->append($card);

        return $this;
    }

    /**
     * Замещиваем карту в колоду игроку
     *
     * @param Game\Player $player
     * @param Game\Card $card
     * @return CardsManager
     */
    public function shuffleToDeck(Game\Player $player, Game\Card $card) : self
    {
        return $this;
    }

    /**
     * @param Game\Player $player
     * @param Game\Card\Minion $card
     * @return $this
     */
    public function placeCardOnBoard(Game\Player $player, Game\Card\Minion $card)
    {
        if(!$player->board->hasVacantPlace()) {
            throw new Game\Exception("There is not place on board");
        }
        
        $player->board->append($card);

        return $this;
    }
}