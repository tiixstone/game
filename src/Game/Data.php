<?php

namespace Tiixstone\Game;

use Tiixstone\Game;
use Tiixstone\Game\Card\Collection\Hand;

class Data
{
    /**
     * @var Naming
     */
    private $naming;

    public function __construct(Naming $naming)
    {
        $this->naming = $naming;
    }

    /**
     * @return array
     */
    public function all(Game $game)
    {
        return [
            'players' => [
                $game->player1->id() => $this->playerData($game, $game->player1),
                $game->player2->id() => $this->playerData($game, $game->player2),
            ],
        ];
    }

    /**
     * @param Player $player
     * @return array
     */
    private function playerData(Game $game, Player $player) : array
    {
        return [
            'id' => $player->id(),
            'haveActions' => ($game->isPlayerCurrent($player) AND $this->haveActions($game, $player)),
            'isActive' => $game->isPlayerCurrent($player),
            'name' => $player->name(),
            'mana' => [
                'crystals' => $player->manaCrystals(),
                'available' => $player->availableMana(),
            ],
            'hero' => [
                'name' => $this->naming->get($player->hero),
                'maximumHealth' => $player->hero->maximumHealth(),
                'health' => $player->hero->health(),
            ],
            'hand' => $this->handData($game, $player->hand, $game->isPlayerCurrent($player)),
            'board' => $this->boardData($game, $player->board, $game->isPlayerCurrent($player)),
            'hand_count' => $player->hand->count(),
            'deck_count' => $player->deck->count(),
            'board_count' => $player->board->count(),
        ];
    }

    /**
     * @param Game $game
     * @param Player $player
     * @return bool
     */
    private function haveActions(Game $game, Player $player)
    {
        // если у карты есть возможность ходить
        foreach($player->hand->all() as $card) {
            if((new Game\Action\PlayCard($card))->canBePlayed($game)) {
                return true;
            }
        }

        // или есть существа, которые могут ходить

        return false;
    }

    /**
     * @param Card\Collection\Board $board
     * @param bool $isActive
     * @return array
     */
    private function boardData(Game $game, Game\Card\Collection\Board $board, bool $isActive) : array
    {
        return array_map(function(Game\Card\Minion $minion) use($game, $isActive) {

            if($isActive) {
                $canAttack = false;

                foreach($game->idlePlayer()->board->all() as $enemyMinion) {
                    if((new Game\Action\MinionAttacksMinion($minion, $enemyMinion))->canAttack($game)) {
                        $canAttack = true;
                        break;
                    }
                }

                $canAttack = (new Game\Action\MinionAttacksHero($minion))->canAttack($game);
            } else {
                $canAttack = false;
            }

            return [
                'name' => $this->naming->get($minion),
                'defaultHealth' => $minion->defaultHealth(),
                'defaultAttackRate' => $minion->defaultAttackRate(),
                'health' => $minion->health($game),
                'attackRate' => $minion->attackRate($game),
                'canAttack' => $canAttack,
            ];
        }, $board->all());
    }

    /**
     * @param Hand $hand
     * @return array
     */
    private function handData(Game $game, Hand $hand, bool $isActive) : array
    {
        return array_map(function(Card $card) use($isActive, $game) {
            $data = [
                'id' => $card->id(),
                'name' => $this->naming->get($card),
                'type' => $card->isMinion() ? 'minion' : 'spell',
            ];

            $data['defaultCost'] = $card->defaultCost();
            $data['cost'] = $card->cost($game);
            $data['canBePlayed'] = ($isActive AND (new Game\Action\PlayCard($card))->canBePlayed($game));

            if($card->isMinion()) {
                /** @var $card Game\Card\Minion */
                $data['defaultHealth'] = $card->defaultHealth();
                $data['defaultAttackRate'] = $card->defaultAttackRate();
                $data['health'] = $card->health($game);
                $data['attackRate'] = $card->attackRate($game);
            }

            return $data;
        }, $hand->all());
    }
}