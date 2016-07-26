<?php declare(strict_types=1);

namespace Tiixstone;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Tiixstone\Game\Action;
use Tiixstone\Game\Card\Minion;
use Tiixstone\Game\Event\GameStarted;
use Tiixstone\Game\Exception;
use Tiixstone\Game\Manager\AttackManager;
use Tiixstone\Game\Manager\BoardManager;
use Tiixstone\Game\Manager\CardsManager;
use Tiixstone\Game\Manager\GameManager;
use Tiixstone\Game\Manager\PlayCardManager;
use Tiixstone\Game\Manager\StatsManager;
use Tiixstone\Game\Player;

class Game
{
    const STATUS_PRE_START = 1;
    const STATUS_STARTED = 2;
    const STATUS_OVER = 3;

    /**
     * @var int
     */
    private $status = self::STATUS_PRE_START;

    /**
     * Номер хода
     *
     * Увеличивается, когда игрок завершает свой ход
     *
     * @var int
     */
    private $turnNumber = 1;

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
    public $eventDispatcher;

    /**
     * @var AttackManager
     */
    public $attackManager;

    public function __construct(
        Player $player1,
        Player $player2,
        EventDispatcher $eventDispatcher,
        GameManager $gameManager,
        CardsManager $cardsManager,
        BoardManager $boardManager,
        AttackManager $attackManager
    )
    {
        $this->player1 = $player1;
        $this->player2 = $player2;

        $this->eventDispatcher = $eventDispatcher;
        $this->gameManager = $gameManager;
        $this->cardsManager = $cardsManager;
        $this->boardManager = $boardManager;
        $this->attackManager = $attackManager;
    }

    /**
     * @return $this
     */
    public function start()
    {
        if($this->status() != self::STATUS_PRE_START) {
            throw new Exception("Game is not in pre started status");
        }

        $this->status = self::STATUS_STARTED;

        $this->gameManager->start($this);

        return $this;
    }

    /**
     * @param Action $action
     * @return bool
     * @throws Exception
     */
    final public function action(Action $action)
    {
        if($this->status() != self::STATUS_STARTED) {
            throw new Exception("Game should be in started status. Run start method");
        }

        $action->process($this);

        $this->gameManager->afterAction($this);

        

        if($this->isOver()) {
            $this->status = self::STATUS_OVER;
        }
    }

    /**
     * @return int
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * @return Player
     */
    public function currentPlayer() : Player
    {
        return $this->turnNumber % 2 ? $this->player1 : $this->player2;
    }

    /**
     * @return Player
     */
    public function idlePlayer() : Player
    {
        return $this->turnNumber % 2 ? $this->player2 : $this->player1;
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
    public function turnNumber() : int
    {
        return $this->turnNumber;
    }

    /**
     * @return $this
     */
    public function incrementMove()
    {
        $this->turnNumber = $this->turnNumber + 1;
        
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
     * Returns false if game is tied
     *
     * @return Player|false
     */
    public function winner()
    {
        if(!$this->player1->hero->isAlive()) {
            return $this->player2;
        } elseif(!$this->player2->hero->isAlive()) {
            return $this->player1;
        } else {
            return false;
        }
    }
}