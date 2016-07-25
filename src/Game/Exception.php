<?php

namespace Tiixstone\Game;

class Exception extends \Exception
{
    const EXCEEDED_MAX_NUMBER_CARDS_IN_HAND = 3;
    const PLAYER_DOESNT_HAVE_CARD_IN_HAND_WITH_REQUIRED_KEY = 5;
    const PLAYER_DOESNT_HAVE_ENOUGH_MANA_TO_PLAY_CARD = 6;
    const EXCEEDED_PLACES_ON_BOARD = 7;
    const MINION_EXHAUSTED_CANT_ATTACK = 8;

    public $codes = [
        1 => 'Action can not be processed, game is over',
        2 => 'Action is invalid and can not be processed',
        3 => 'Exceeded max number of cards in hand',
        4 => 'Not enough mana',
        5 => 'Player does not have card with required key',
        6 => 'Player does not have enough mana to play card',
        7 => 'There is not place on board',
        8 => '',
    ];
}