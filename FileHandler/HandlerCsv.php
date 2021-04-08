<?php

class HandlerCsv extends MFileHandler implements PFileHandler{

    function __construct($directory,$filename)
    {       
        parent::__construct($directory,$filename);
    }

    function SaveFile($value){

        $this->CreateDirectory($this->directory);
        $path = $this->directory . "/". $this->filename . ".csv";

        $file = fopen($path,"w+");
        $newList = array($value);

        foreach($value as $data2) {
            fputcsv($file, get_object_vars($data2));
        }
        
        fclose($file);
        
    }

    function ReadFile(){
        
        parent::CreateDirectory($this->directory);
        $path = $this->directory . "/". $this->filename . ".csv";    

        if(file_exists($path)){
            $myVar = array();
            $newList = array();
            $file = fopen($path,"r");

            while (($line = fgetcsv($file)) !== FALSE) {
                array_push($myVar, $line);
            }
            foreach($myVar as $key => $data){
                $newCsv = new Trasacciones($myVar[$key][0], $myVar[$key][1], $myVar[$key][2], $myVar[$key][3]);   
                $newList = array_merge($newList, array($newCsv));
            }

            return($newList);
          
        }else{
            return false;
        }      

    }

    function EditCsv($path){
        $newCsvData = array();
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000)) !== FALSE) {
                array_unshift($data, '');
                array_unshift($data, '');
                $newCsvData[] = $data;
            }
            fclose($handle);
        }

        $handle = fopen($path, 'w');

        foreach ($newCsvData as $line) {
            fputcsv($handle, $line);
        }

        fclose($handle);
    }
    
}

?>