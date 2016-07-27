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
    private $card;

    /**
     * @var Game\Card
     */
    private $targetCard;

    public function __construct(Game\Card $card, Game\Card $targetCard = null)
    {
        $this->card = $card;
        $this->targetCard = $targetCard;
    }

    public function process(Game $game)
    {
        if(($exception = $this->canBePlayed($game, true)) !== true) {
            throw $exception;
        }

        $game->gameManager->reducePlayerAvailableMana($game, $game->currentPlayer(), $this->card->cost($game));

        $game->currentPlayer()->hand->pull($this->card->id());

        $game->eventDispatcher->dispatch(CardPlayed::NAME, new CardPlayed($game->currentPlayer(), $this->card));

        if($this->card instanceof Game\Card\Minion) {
            $game->boardManager->placeCardOnBoard($game->currentPlayer(), $this->card, $this->targetCard);
        }

        $this->card->play($game, $this->targetCard);
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
                    sprintf("Player does not have card with key [%s]", $this->card->id()),
                    Game\Exception::PLAYER_DOESNT_HAVE_CARD_IN_HAND_WITH_REQUIRED_KEY
                );
            } else {
                return false;
            }
        }

        if(!$this->playerHasEnoughMana($game)) {
            if($throwException) {
                return new Game\Exception(
                    sprintf("Player does not have enough mana"),
                    Game\Exception::PLAYER_DOESNT_HAVE_ENOUGH_MANA_TO_PLAY_CARD
                );
            } else {
                return false;
            }

        }

        if($this->card->isMinion() AND !$this->vacantPlaceOnBoard($game)) {
            if($throwException) {
                return new Game\Exception("There is no vacant place on board", Game\Exception::EXCEEDED_PLACES_ON_BOARD);
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Game $game
     * @return bool
     */
    private function cardExists(Game $game)
    {
        return $game->currentPlayer()->hand->has($this->card->id());
    }

    /**
     * @param Game $game
     * @param Game\Card $card
     * @return bool
     */
    private function playerHasEnoughMana(Game $game)
    {
        return $game->currentPlayer()->availableMana() >= $this->card->cost($game);
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