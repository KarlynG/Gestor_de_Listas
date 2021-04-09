<?php

class HandlerJson extends MFileHandler implements PFileHandler{

    function __construct($directory,$filename)
    {       
        parent::__construct($directory,$filename);
    }

    function SaveFile($value){

        $this->CreateDirectory($this->directory);
        $path = $this->directory . "/". $this->filename . ".json";

        $jsonData = json_encode($value);

        $file = fopen($path,"w+");
        fwrite($file,$jsonData);
        fclose($file);
    }

    function ReadFile(){

        parent::CreateDirectory($this->directory);
        $path = $this->directory . "/". $this->filename . ".json";      

        if(file_exists($path)){
            $file = fopen($path,"r");

            $contents = fread($file,filesize($path));
            fclose($file);
            return json_decode($contents);
          
        }else{
            return false;
        }      

    }
    
}

?>