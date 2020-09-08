<?php

namespace ZnCore\Base\Console\Helpers;

use Symfony\Component\Console\Output\OutputInterface;

class OutputHepler
{

    public static function writeList(OutputInterface $output, array $array)
    {
        foreach ($array as $item) {
            $output->writeln(' ' . $item);
        }
    }

}