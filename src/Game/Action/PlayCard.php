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
        $card = $game->cardsManager->getCardFromHand($game->currentPlayer(), $this->id());

        $game->gameManager->reducePlayerMana($game->currentPlayer(), $card->cost());

        if($card instanceof Game\Card\Minion) {
            $game->cardsManager->placeCardOnBoard($game->currentPlayer(), $card);
        }
    }

    /**
     * @return string
     */
    public function id() : string
    {
        return $this->id;
    }
}