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
        return array_values($this->cards)[0];
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

        unset($this->cards[$key]);

        return $card;
    }

    /**
     * @return array|\Tiixstone\Game\Card[]
     */
    public function all()
    {
        return $this->cards;
    }
}