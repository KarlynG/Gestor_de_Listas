<?php 
    Class LogEvent{

        function WriteLog($text){
            $path = "Mis Transacciones/log.txt";

            $file = fopen($path,"a+");
            $text = $text.','."\n";
            fwrite($file, $text);
            fclose($file);
        }

        function ReadLog(){
            $path = "actions/Mis Transacciones/log.txt";
            $file = fopen($path,"a+");
            fclose($file);
            $file = file_get_contents($path);

            return($file);

        }

        function CreateLog(){
            $path = "actions/Mis Transacciones";
            if(!file_exists($path)){
                mkdir($path,0777,true);
            }
        }

    }




?>