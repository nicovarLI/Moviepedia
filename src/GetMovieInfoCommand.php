<?php namespace Acme;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Acme\Command;


          
class GetMovieInfoCommand extends Command{

    function configure()
    {
        $this->setName('show')
             ->setDescription('Get information of a specified movie')
             ->addArgument('title',InputArgument::REQUIRED,'Title of the movie to search')
             ->addOption('fullPlot',null,InputOption::VALUE_NONE,'Displays the full plot of the movie');
    }
    function execute(InputInterface $input, OutputInterface $output)
    {
        $movieInfo = $this->getInfo($input);
        $this->render($output, $movieInfo);
        return command::SUCCESS;
    }
}