<?php

namespace Tiixstone\Game;

/**
 * Class Event
 *
 * Класс событий
 * Например: завершение хода игрока, начала хода игрока
 *
 * @package Tiixstone\Game
 */
abstract class Event extends \Symfony\Component\EventDispatcher\Event
{
}