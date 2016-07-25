<?php declare(strict_types=1);

namespace Tiixstone\Game\Action;

use Tiixstone\Game;
use Tiixstone\Game\Action;
use Tiixstone\Game\Event\CardPlayed;

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
        if(($exception = $this->canBePlayed($game, true)) !== true) {
            throw $exception;
        }

        $card = $game->cardsManager->getCardFromHand($game->currentPlayer(), $this->id());

        $game->gameManager->reducePlayerMana($game->currentPlayer(), $card->cost($game));

        if($card instanceof Game\Card\Minion) {
            $game->boardManager->placeCardOnBoard($game->currentPlayer(), $card);
        }

        $card->play($game);

        $game->eventDispatcher->dispatch(CardPlayed::NAME, new CardPlayed($game->currentPlayer(), $card));
    }

    /**
     * @param Game $game
     * @param bool $throwException
     * @return bool|Game\Exception
     * @throws Game\Exception
     */
    public function canBePlayed(Game $game, $throwException = false)
    {
        if(!$this->cardExists($game)) {
            if($throwException) {
                return new Game\Exception(
                    sprintf("Player does not have card with key [%s]", $this->id()),
                    Game\Exception::PLAYER_DOESNT_HAVE_CARD_IN_HAND_WITH_REQUIRED_KEY
                );
            } else {
                return false;
            }
        }

        $card = $game->currentPlayer()->hand->get($this->id());

        if(!$this->playerHasEnoughMana($game, $card)) {
            if($throwException) {
                return new Game\Exception(
                    sprintf("Player does not have enough mana"),
                    Game\Exception::PLAYER_DOESNT_HAVE_ENOUGH_MANA_TO_PLAY_CARD
                );
            } else {
                return false;
            }

        }

        if($card->isMinion() AND !$this->vacantPlaceOnBoard($game)) {
            if($throwException) {
                return new Game\Exception("There is no vacant place on board", Game\Exception::EXCEEDED_PLACES_ON_BOARD);
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    public function id() : string
    {
        return $this->id;
    }

    /**
     * @param Game $game
     * @return bool
     */
    private function cardExists(Game $game)
    {
        return $game->currentPlayer()->hand->has($this->id());
    }

    /**
     * @param Game $game
     * @param Game\Card $card
     * @return bool
     */
    private function playerHasEnoughMana(Game $game, Game\Card $card)
    {
        return $game->currentPlayer()->availableMana() >= $card->cost($game);
    }

    /**
     * @param Game $game
     * @return bool
     */
    private function vacantPlaceOnBoard(Game $game)
    {
        return $game->boardManager->hasVacantPlace($game->currentPlayer());
    }
}