<?php declare(strict_types=1);

namespace Tiixstone\Game\Card;

use Tiixstone\Game\Card;
use Tiixstone\Game\Exception;

abstract class Collection
{
    /**
     * @var Card[]
     */
    protected $cards;
    
    public function __construct(array $cards = [])
    {
        $this->cards = $cards;
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
    public function append(Card $card) : self
    {
        $this->cards[] = $card;

        return $this;
    }

    /**
     * @return mixed
     */
    public function shift()
    {
        if(!$this->count()) {
            throw new Exception("No more cards to shift");
        }

        return array_shift($this->cards);
    }

    /**
     * @param $key
     * @return bool
     */
    public function has(int $key) : bool
    {
        return isset($this->cards[$key]);
    }

    /**
     * @param $key
     * @return Card
     * @throws Exception
     */
    public function get($key) : Card
    {
        if(!isset($this->cards[$key])) {
            throw new Exception(sprintf("Card with key %s does not exist", $key));
        }

        return $this->cards[$key];
    }
}