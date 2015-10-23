<?php

namespace Con\Tools\Commands;

use Con\Tools\Lib\ImageOptimizer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImageOptimizerCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('image:optimize')
            ->setDescription('Optimize images using imagemagic library')
            ->addArgument(
                'directory',
                InputArgument::REQUIRED,
                'Directory'
            )
            ->addOption(
                'r',
                null,
                InputOption::VALUE_NONE,
                'Recursive Optimization'
            )

            ->addOption(
                'quality',
                null,
                InputOption::VALUE_OPTIONAL,
                'Quality of the image 0-100'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $directory = $input->getArgument('directory');
        $recursive=false;

        if ($input->getOption('r')) {
            $recursive=true;
        }

        $quality=$input->getOption('quality');

        $optimizer=new ImageOptimizer();
        $optimizer->setPath($directory);

        if($quality){
            $optimizer->setQuality($quality);
        }

        $optimizer->optimize();

    }

}