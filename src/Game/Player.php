<?php declare(strict_types=1);

namespace Tiixstone\Game;

use Tiixstone\Game\Card\Collection\Board;
use Tiixstone\Game\Card\Collection\Deck;
use Tiixstone\Game\Card\Collection\Hand;

class Player
{
    /**
     * @var int
     */
    protected $fatigue = 1;

    /**
     * @var int
     */
    protected $availableMana = 0;

    /**
     * @var int
     */
    protected $manaCrystals = 0;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Hero
     */
    public $hero;

    /**
     * @var Hand
     */
    public $hand;

    /**
     * @var Deck
     */
    public $deck;

    /**
     * @var Board
     */
    public $board;

    public function __construct(string $name, Hero $hero, Deck $deck, Hand $hand, Board $board)
    {
        $this->name = $name;
        $this->hero = $hero;
        $this->deck = $deck;
        $this->hand = $hand;
        $this->board = $board;
    }

    /**
     * @return string
     */
    public function name() : string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function availableMana() : int
    {
        return $this->availableMana;
    }

    /**
     * @param int $availableMana
     * @return Player
     */
    public function setAvailableMana(int $availableMana) : self
    {
        $this->availableMana = $availableMana;

        return $this;
    }

    /**
     * @return Player
     */
    public function incrementAvailableMana() : self
    {
        $this->setAvailableMana($this->availableMana + 1);

        return $this;
    }

    /**
     * @return Player
     */
    public function reduceAvailableMana(int $amount) : self
    {
        if($amount > $this->availableMana) {
            throw new Exception("Not enough mana", 4);
        }

        $this->setAvailableMana($this->availableMana - $amount);

        return $this;
    }

    /**
     * @return int
     */
    public function manaCrystals() : int
    {
        return $this->manaCrystals;
    }

    /**
     * @param int $manaCrystals
     * @return Player
     */
    public function setManaCrystals(int $manaCrystals) : self
    {
        $this->manaCrystals = $manaCrystals;

        return $this;
    }

    /**
     * @return Player
     */
    public function incrementManaCrystals() : self
    {
        $this->setManaCrystals($this->manaCrystals + 1);

        return $this;
    }

    /**
     * @return int
     */
    public function fatigue()
    {
        return $this->fatigue;
    }

    /**
     * @return $this
     */
    public function incrementFatigue() : self
    {
        $this->fatigue = $this->fatigue + 1;

        return $this;
    }
}