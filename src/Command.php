<?php namespace Acme;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;
use Symfony\Component\Console\Helper\Table;

class Command extends SymfonyCommand{

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://www.omdbapi.com/',
            'timeout'  => 10.0,
        ]);

        parent::__construct();
    }
    protected function getInfo(InputInterface $input)
    {
        $title = $input->getArgument('title');
        $plot = '';
        if($input->getOption('fullPlot')){
            $plot = '&plot=full';
        }
        $request = $this->client->request('GET','/?t='.$title.$plot.'&apikey=473bcac3');
        $response = json_decode($request->getBody(),true);
        return $response;
    }
    protected function render(OutputInterface $output,$response)
    {
        $tableTitle = $response['Title'].' - '.$response['Year'];
        $titles = array_keys($response);
        $rows = $this->prepareRows($response);
        $table = new Table($output);
        $table->setHeaders($titles)
              ->setHeaderTitle($tableTitle)
              ->setHorizontal()
              ->setColumnMaxWidth(1, 120)
              ->addRow($rows);
        $table->render();
        
    }
    private function prepareRows(array $response)
    {
        $rows = array();
        foreach ($response as $row){
            if(is_array($row)){
                $rating ="\n";
                foreach($row as $rowData){
                    $rating .="{$rowData['Source']}: {$rowData['Value']}\n";
                }
               array_push($rows,$rating);
            }else{
                array_push($rows,$row);
            }
        }
        return $rows;
    }
}