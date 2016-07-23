<?php

namespace Tiixstone\Game;

use Tiixstone\Game;

/**
 * Class Action
 *
 * Класс действия, которое может совершить игрок.
 * Например: завершить ход, разыграть карту, походить существом и т.д.
 *
 * @package Tiixstone\Game
 */
abstract class Action
{
    abstract public function process(Game $game);
}