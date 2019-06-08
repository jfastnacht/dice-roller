<?php
namespace JFastnacht\DiceRoller\Command;

use JFastnacht\DiceRoller\Exception\CharacterNotAllowedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RollCommand extends Command
{
    protected function configure()
    {
        $this->setName('dice:roll')
            ->setDescription("Roll the dice.")
            ->addArgument('dice');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dice = $input->getArgument('dice');
        /*
         * Possible inputs
         *  d4
         *  1d4
         *  1d4+1
         *  1d4-1
         *  1d4+1d8
         *  2d20
         *  2d4+3d6+5
         */
        $output->writeln($this->executeDiceRoll($dice));
    }

    public function executeDiceRoll($rawRollText)
    {
        $exec = $this->parseDiceRoll($rawRollText);
        return eval("return ".$exec.";");
    }

    public function parseDiceRoll($rawRollText)
    {
        $strippedRollText = str_replace(" ", "", $rawRollText);
        if (preg_match("/[^0-9d+\-]/", $strippedRollText)) {
            throw new CharacterNotAllowedException();
        }
        $exec = preg_replace('/([0-9]*)d([0-9]+)/', '\$this->roll($1,$2)', $strippedRollText);
        return str_replace('roll(,', 'roll(1,', $exec);
    }

    public function roll($dice, $sides)
    {
        $sum = 0;
        for ($i=0; $i<$dice; $i++) {
            $sum += rand(1, $sides);
        }
        return $sum;
    }
}
