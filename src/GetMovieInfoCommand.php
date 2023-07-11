<?php namespace Acme;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use GuzzleHttp\Client;

          
class GetMovieInfoCommand extends Command{
    
    protected $client;
    function configure(){

        $this->setName('show')
             ->setDescription('Get information of a specified movie')
             ->addArgument('title',InputArgument::REQUIRED,'Title of the movie to search');
        $this->client = new Client([
                 // Base URI is used with relative requests
                 'base_uri' => 'http://httpbin.org',
                 // You can set any number of default request options.
                 'timeout'  => 2.0,
             ]);
    }
    function execute(InputInterface $input, OutputInterface $output){
        $title = $input->getArgument('title');
        //http request with guzzle here

    }
}