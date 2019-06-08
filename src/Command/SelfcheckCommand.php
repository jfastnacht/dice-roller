<?php
namespace JFastnacht\DiceRoller\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SelfcheckCommand extends Command
{
    protected function configure()
    {
        $this->setName('dice:selfcheck')
            ->setDescription("Selfcheck for the randomizer.")
            ->addArgument('iterations', null, 'Number of iterations for selfcheck.', '128');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Set dice roll to 255 for color range
        $diceRoll = "1d255";

        // Create a square and run dice rolls to fill pixels with dice results of RollCommand
        $command = new RollCommand();
        $iterations = $input->getArgument('iterations');
        $image = imagecreatetruecolor($iterations, $iterations);
        for ($x=0; $x<$iterations; $x++) {
            for ($y=0; $y<$iterations; $y++) {
                $diceResult = $command->executeDiceRoll($diceRoll);
                imagesetpixel($image, $x, $y, imagecolorallocate($image, $diceResult, $diceResult, $diceResult));
                unset($diceResult);
            }
        }

        // Save generated image to temp directory and output path
        $tempFilePath = tempnam(sys_get_temp_dir(), 'DiceRoller').".png";
        if (imagepng($image, $tempFilePath)) {
            $output->writeln(sprintf("Created temporary file at %s", $tempFilePath));
        } else {
            $output->writeln(sprintf("There was a problem creating the image at %s", $tempFilePath));
        }
    }
}
