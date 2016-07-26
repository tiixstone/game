<?php declare(strict_types=1);

namespace Tiixstone\Game\Card;

use Tiixstone\Game\Card;
use Tiixstone\Game\Exception;

abstract class Collection
{
    /**
     * @var Card[]
     */
    protected $cards = [];

    /**
     * Collection constructor.
     *
     * @param Card[] $cards
     */
    public function __construct(array $cards = [])
    {
        foreach($cards as $card) {
            $this->append($card);
        }
    }

    /**
     * Добавляет карту перед другой картой
     *
     * @param Card $card
     * @param string $id
     * @return $this
     * @throws Exception
     */
    public function addBefore(Card $card, string $id)
    {
        $targetCard = $this->get($id);

        $position = 0;
        foreach($this->all() as $item) {
            if($item->id() == $targetCard->id()) {
                break;
            }

            $position++;
        }

        $this->cards = array_merge(
            array_slice($this->cards, 0, $position),
            [$card],
            array_slice($this->cards, $position)
        );

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return !$this->count();
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->cards);
    }

    /**
     * @param Card $card
     * @return Collection
     */
    public function append(Card $card)
    {
        $this->cards[$card->id()] = $card;

        return $this;
    }

    /**
     * @param Card[] $cards
     * @return $this
     */
    public function appendMany(array $cards)
    {
        foreach($cards as $card) {
            $this->append($card);
        }

        return $this;
    }

    /**
     * @param int $position
     * @return Card
     * @throws Exception
     */
    public function getByPosition(int $position) : Card
    {
        $i=1;
        foreach($this->all() as $card) {
            if($position == $i) {
                return $card;
            }

            $i++;
        }

        throw new Exception(sprintf("Card with position [%s] does not exist", $position));
    }

    /**
     * @return Card
     */
    public function shift() : Card
    {
        if(!$this->count()) {
            throw new Exception("No more cards to shift");
        }

        return array_shift($this->cards);
    }

    /**
     * @return Card
     */
    public function first() : Card
    {
        if(!$this->count()) {
            throw new Exception("Collection is empty");
        }

        return reset($this->cards);
    }

    /**
     * @return Card
     */
    public function last() : Card
    {
        if(!$this->count()) {
            throw new Exception("Collection is empty");
        }

        return end($this->cards);
    }

    /**
     * @param $key
     * @return bool
     */
    public function has(string $key) : bool
    {
        return isset($this->cards[$key]);
    }

    /**
     * @param $key
     * @return Card
     * @throws Exception
     */
    public function get(string $key) : Card
    {
        if(!isset($this->cards[$key])) {
            throw new Exception(sprintf("Card with key %s does not exist", $key));
        }

        return $this->cards[$key];
    }

    /**
     * @param $key
     * @return Card
     * @throws Exception
     */
    public function pull(string $key) : Card
    {
        $card = $this->get($key);

        $this->remove($key);

        return $card;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function remove(string $key)
    {
        unset($this->cards[$key]);

        return $this;
    }

    /**
     * @return array|\Tiixstone\Game\Card[]
     */
    public function all()
    {
        return $this->cards;
    }

    /**
     * @param string $key
     * @return bool|mixed|Card
     */
    public function prev(string $key)
    {
        $position = false;

        $i=0;
        foreach($this->all() as $card) {
            if($card->id() == $key) {
                $position = $i;
                break;
            }

            $i++;
        }

        $i=0;
        foreach($this->all() as $card) {
            if($i == ($position - 1)) {
                return $card;
            }

            $i++;
        }

        return false;
    }

    /**
     * @param string $key
     * @return bool|mixed|Card
     */
    public function next(string $key)
    {
        $position = false;

        $i=0;
        foreach($this->all() as $card) {
            if($card->id() == $key) {
                $position = $i;
                break;
            }

            $i++;
        }

        if($position === false OR $position == ($this->count() - 1)) {
            return false;
        }

        $i=0;
        foreach($this->all() as $card) {
            if($i == ($position + 1)) {
                return $card;
            }

            $i++;
        }

        return false;
    }
}