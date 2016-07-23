<?php declare(strict_types=1);

namespace Tiixstone\Game\Action;

use Tiixstone\Game;
use Tiixstone\Game\Action;

class PlayCard extends Action
{
    /**
     * @var int
     */
    private $key;

    public function __construct(int $key)
    {
        $this->key = $key;
    }

    public function process(Game $game)
    {
        $card = $game->cardsManager->getCardFromHand($game->currentPlayer(), $this->key());

        $game->gameManager->reducePlayerMana($game->currentPlayer(), $card->cost());

        if($card instanceof Game\Card\Minion) {
            $game->cardsManager->placeCardOnBoard($game->currentPlayer(), $card);
        }
    }

    /**
     * @return int
     */
    public function key() : int
    {
        return $this->key;
    }
}