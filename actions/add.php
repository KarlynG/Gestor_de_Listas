<?php
require_once '../HandyActions/utilities.php';
require_once '../FileHandler/MFileHandler.php'; 
require_once '../FileHandler/PFileHandler.php';
require_once '../FileHandler/HandlerJson.php';
require_once '../FileHandler/HandlerSerialization.php';
require_once '../FileHandler/HandlerCsv.php';
require_once 'log.php';
require_once 'transacciones.php';
require_once 'filemanager.php';


    $log = new LogEvent;
    date_default_timezone_set("America/New_York");
    $actualTime = date("F j Y g:i a", time());

    if(isset($_POST["CantidadMonto"]) && isset($_POST["DescripcionMonto"])){
        $manager = new FileManager(false, 'transacciones', $_POST["handlerType"]);
        $transaccion = new Trasacciones(0, $actualTime, $_POST["CantidadMonto"], $_POST["DescripcionMonto"]);
        $idNewElement = array($transaccion);

        $idNewElement = $manager->Add($transaccion);
        if($idNewElement == null){
            $idNewElement = 1;
        }

        if($_POST["handlerType"] == 'HandlerJson'){
            $log->WriteLog("Se agrego la transaccion #". $idNewElement.' el : '.$actualTime.' en JSON');
        }elseif($_POST["handlerType"] == 'HandlerSerialization'){
            $log->WriteLog("Se agrego la transaccion #". $idNewElement.' el : '.$actualTime.' en Serializacion');
        }else{
            $log->WriteLog("Se agrego la transaccion #". $idNewElement.' el : '.$actualTime.' en CSV');
        }

        header("Location: ../index.php");
        exit();
    }

    if(isset($_FILES['archivo']['name'])){
        $nombreLista = $_FILES['archivo']['name'];
        if(substr($nombreLista, -4) == '.csv' && $_POST["handlerType2"] == 'HandlerCsv'){
            $newName = str_replace('.csv', '', $nombreLista);    
        }elseif(substr($nombreLista, -5) == '.json' && $_POST["handlerType2"] == 'HandlerJson'){
            $newName = str_replace('.json', '', $nombreLista);
        }else{
            header("Location: ../index.php?error=true");
            exit();
        }

        $listaLocation = $_FILES['archivo']['tmp_name'];
        move_uploaded_file($listaLocation, 'Mis Transacciones/'.$nombreLista);

        $manager = new FileManager(false, 'transacciones', $_POST["handlerType2"]);
        $manager2 = new FileManager(false, $newName, $_POST["handlerType2"]);
        
        if($_POST["handlerType2"] == 'HandlerCsv'){
            $path = 'Mis Transacciones/'.$nombreLista;
            $manager2->fileHandler->EditCsv($path);
        }
        
        $New_Transactions = $manager2->GetList();

        $manager->Add($New_Transactions, true);

        if($_POST["handlerType"] == 'HandlerJson'){
            $log->WriteLog("Se agregaron multiples transacciones el: ". $actualTime.' en JSON');
        }else{
            $log->WriteLog("Se agregaron multiples transacciones el: ". $actualTime.' en CSV');
        }


        header("Location: ../index.php");

    }

?>