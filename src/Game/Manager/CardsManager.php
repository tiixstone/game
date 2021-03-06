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
     * @var int
     */
    protected $maxCardsInHand = 10;

    /**
     * @return int
     */
    public function maxCardsInHand() : int
    {
        return $this->maxCardsInHand;
    }

    /**
     * Получаем карту из руки
     *
     * @param Game\Player $player
     * @param string $id
     * @return Game\Card
     * @throws Game\Exception
     */
    public function getCardFromHand(Game\Player $player, string $id)
    {
        if(!$player->hand->has($id)) {
            throw new Game\Exception(
                sprintf("Player does not have card with key [%s]", $id),
                Game\Exception::PLAYER_DOESNT_HAVE_CARD_IN_HAND_WITH_REQUIRED_KEY
            );
        }
        
        return $player->hand->pull($id);
    }
    
    /**
     * Перекладываем карту из колоды в руку игрока
     *
     * @param Game\Player $player
     * @return $this
     * @throws Game\Exception
     */
    public function draw(Game $game, Game\Player $player) : self
    {
        $card = $this->getCardFromDeck($game, $player);

        if($card instanceof Game\Card) {
            $this->appendToHand($player, $card);
        }

        return $this;
    }

    /**
     * @param Game\Player $player
     * @param int $amount
     * @return $this
     */
    public function drawMany(Game $game, Game\Player $player, int $amount) : self
    {
        for ($i = 0; $i < $amount; $i++) {
            $this->draw($game, $player);
        }

        return $this;
    }

    /**
     * @param Game\Player $player
     * @return Game\Card
     * @throws Game\Exception
     */
    public function getCardFromDeck(Game $game, Game\Player $player)
    {
        if($player->deck->count()) {
            return $player->deck->shift();
        }

        $game->attackManager->fatigue($game, $player);

        return false;
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
        if($player->hand->count() >= $this->maxCardsInHand()) {
            return $this;
        }
        
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
}