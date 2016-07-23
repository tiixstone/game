<?php declare(strict_types=1);

namespace Tiixstone\Game\Action;

use Tiixstone\Game;
use Tiixstone\Game\Action;

class PlayCard extends Action
{
    /**
     * @var int
     */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function process(Game $game)
    {
        if(!$game->currentPlayer()->hand->has($this->id())) {
            throw new Game\Exception(
                sprintf("Player does not have card with key [%s]", $this->id()),
                Game\Exception::PLAYER_DOESNT_HAVE_CARD_IN_HAND_WITH_REQUIRED_KEY
            );
        }

        $card = $game->currentPlayer()->hand->get($this->id());

        if($game->currentPlayer()->availableMana() < $card->cost()) {
            throw new Game\Exception(
                sprintf("Player does not have enough mana"),
                Game\Exception::PLAYER_DOESNT_HAVE_ENOUGH_MANA_TO_PLAY_CARD
            );
        }

        $card = $game->cardsManager->getCardFromHand($game->currentPlayer(), $this->id());

        $game->gameManager->reducePlayerMana($game->currentPlayer(), $card->cost());

        if($card instanceof Game\Card\Minion) {
            $game->cardsManager->placeCardOnBoard($game->currentPlayer(), $card);
        } elseif($card instanceof Game\Card\Spell)
            $card->play($game);
    }

    /**
     * @return string
     */
    public function id() : string
    {
        return $this->id;
    }
}