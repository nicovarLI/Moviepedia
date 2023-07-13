<?php namespace Acme;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use GuzzleHttp\Client;

          
class GetMovieInfoCommand extends Command{

    function configure(){

        $this->setName('show')
             ->setDescription('Get information of a specified movie')
             ->addArgument('title',InputArgument::REQUIRED,'Title of the movie to search')
             ->client = new Client([
                 'base_uri' => 'http://www.omdbapi.com/',
                 'timeout'  => 10.0,
             ]);
    }
    function execute(InputInterface $input, OutputInterface $output){
        $title = $input->getArgument('title');
        $request = $this->client->request('GET','/?t='.$title.'&apikey=473bcac3');
        
        $this->render($output, $request);
        return command::SUCCESS;
    }

    private function render(OutputInterface $output,$request){
        $response = json_decode($request->getBody(),true);
        $aux = array();
        $tableTitle = $response['Title'].' - '.$response['Year'];
        foreach ($response as $key => $row){
            if(is_array($row)){
                $rating ='';
                foreach($row as $arr){
                    $rating = $rating.$arr['Source'].': '.$arr['Value'].' || ';
                }
               array_push($aux,$rating);
            }else{
                array_push($aux,$row);
            }
        }
        $titles = array_keys($response);
        $table = new Table($output);
        $table->setHeaders($titles)
              ->setHeaderTitle($tableTitle)
              ->setHorizontal()
              ->addRow($aux);
              $table->render();
        
    }
}