<?php
namespace JFastnacht\DiceRoller\Exception;

class CharacterNotAllowedException extends \Exception
{
    public function __toString()
    {
        return "Character not allowed in dice roll.";
    }
}