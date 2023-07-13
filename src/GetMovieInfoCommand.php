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
        $arr = array();
        $aux = array();
        //$info = array_values($response);
        foreach ($response as $row){
            //var_dump($data);
            //$aux[] = $row;
            if(is_array($row)){
               $str = implode(",",$row);
               array_push($aux,$str);
            }else{
            array_push($aux,$row);
            }
            //$cont+=1;
            //var_dump($cont);
            //$aux = array($data);
            //array_push($arr,$aux);
            //aux no esta siendo array, ver eso, valor displayed
        }

        $arr[0]= $aux;
        //var_dump($arr);
        //var_dump($arr);
        $titles = array_keys($response);
        $table = new Table($output);
        $table->setHeaders($titles)
              ->setHorizontal()
              ->addRow($aux);
              $table->render();
        //foreach($aux as $row){
        //        $arr[]= $row;
        //        var_dump($row);
        //        var_dump($arr);
                //$table->addRow($arr);
        //}
       // foreach ($response as $row){
         //   if(!is_array($row)){
           //     $rowData = explode(',',$row);
             //   $table->addRow($rowData);
            //}else{
              //  $table->addRow($row);
            //}
        //}
        
        //$rows = array_map(function ($item) {
        //    return is_array($item) ? array_values($item) : [$item];
        //}, $response);

        // Add the rows to the table
        //foreach ($rows as $row) {
        //    $table->addRow($row);
        //}
        
        
        //$rows = [];
        //foreach ($response as $row) {
            //if(is_string($row)){
            //    $rowData = explode(',',$row);
          //  }else{
        //        $rowData = $row;
        //    }
        //    $rows[] = array_values($rowData);
        //}
        //$table->setRows($rows);
        
              //->addRows($arr)
        
        
    }
}