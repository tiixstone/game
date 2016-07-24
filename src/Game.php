<?php declare(strict_types=1);

namespace Tiixstone;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Tiixstone\Game\Action;
use Tiixstone\Game\Exception;
use Tiixstone\Game\Manager\BoardManager;
use Tiixstone\Game\Manager\CardsManager;
use Tiixstone\Game\Manager\GameManager;
use Tiixstone\Game\Manager\PlayCardManager;
use Tiixstone\Game\Player;

class Game
{
    /**
     * Номер хода
     *
     * Увеличивается, когда игрок завершает свой ход
     *
     * @var int
     */
    private $moveNumber = 0;

    /**
     * Игрок, который ходит первым
     *
     * @var Player
     */
    public $player1;

    /**
     * Игрок, который ходит вторым
     *
     * @var Player
     */
    public $player2;

    /**
     * @var GameManager
     */
    public $gameManager;

    /**
     * @var CardsManager
     */
    public $cardsManager;

    /**
     * @var BoardManager
     */
    public $boardManager;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    public function __construct(
        Player $player1,
        Player $player2,
        EventDispatcher $eventDispatcher,
        GameManager $gameManager,
        CardsManager $cardsManager,
        BoardManager $boardManager
    )
    {
        $this->player1 = $player1;
        $this->player2 = $player2;

        $this->eventDispatcher = $eventDispatcher;
        $this->gameManager = $gameManager;
        $this->cardsManager = $cardsManager;
        $this->boardManager = $boardManager;

        $this->gameManager->start($this);

        $this->gameManager->beginTurn($this);
    }

    /**
     * @param Action $action
     * @return bool
     * @throws Exception
     */
    final public function action(Action $action) : bool
    {
        if($this->isOver()) {
            throw new Exception(
                sprintf(
                    "Can not process action. Game is over. Player1 hero health is %s, player2 hero health is %s",
                    $this->player1->hero->health(),
                    $this->player2->hero->health()
            ), 1);
        }
        
        $action->process($this);

        return $this->isOver();
    }

    /**
     * @return Player
     */
    public function currentPlayer() : Player
    {
        return $this->moveNumber % 2 ? $this->player2 : $this->player1;
    }

    /**
     * @return Player
     */
    public function idlePlayer() : Player
    {
        return $this->moveNumber % 2 ? $this->player1 : $this->player2;
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function isPlayerCurrent(Player $player) : bool
    {
        return $player->id() == $this->currentPlayer()->id();
    }

    /**
     * @return int
     */
    public function moveNumber()
    {
        return $this->moveNumber;
    }

    /**
     * @return $this
     */
    public function incrementMove()
    {
        $this->moveNumber = $this->moveNumber + 1;
        
        return $this;
    }

    /**
     * @return bool
     */
    public function isOver() : bool
    {
        return !$this->player1->hero->isAlive() OR !$this->player2->hero->isAlive();
    }

    /**
     * @return Player
     */
    public function winner() : Player
    {
        return $this->player1->hero->isAlive() ? $this->player1 : $this->player2;
    }
}