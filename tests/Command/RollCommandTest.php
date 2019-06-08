<?php
namespace JFastnacht\DiceRoller\Tests\Command;

use JFastnacht\DiceRoller\Command\RollCommand;
use JFastnacht\DiceRoller\Exception\CharacterNotAllowedException;
use PHPUnit\Framework\TestCase;

class RollCommandTest extends TestCase
{
    public function testDiceRollParser()
    {
        $command = new RollCommand;
        $parsedRoll = $command->parseDiceRoll("1d4+1");
        $this->assertEquals('$this->roll(1,4)+1', $parsedRoll);
    }

    public function testDiceRollParserWithoutDiceAmount()
    {
        $command = new RollCommand;
        $parsedRoll = $command->parseDiceRoll("d4+1");
        $this->assertEquals('$this->roll(1,4)+1', $parsedRoll);
    }

    public function testDiceRoll()
    {
        $command = new RollCommand;
        $rollResult = $command->roll(1, 20);
        $this->assertGreaterThanOrEqual(1, $rollResult);
        $this->assertLessThanOrEqual(20, $rollResult);
    }

    public function testDiceParserAndRoll()
    {
        $command = new RollCommand;
        $rollResult = $command->executeDiceRoll("1d4+1");
        $this->assertGreaterThanOrEqual(2, $rollResult);
        $this->assertLessThanOrEqual(5, $rollResult);
    }

    public function testDiceParserException()
    {
        $this->expectException("\JFastnacht\DiceRoller\Exception\CharacterNotAllowedException");
        $command = new RollCommand;
        $parsedRoll = $command->parseDiceRoll("1w4+2");
    }
}
