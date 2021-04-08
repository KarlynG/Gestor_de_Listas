<?php 
require_once '../HandyActions/utilities.php';
require_once '../FileHandler/MFileHandler.php'; 
require_once '../FileHandler/PFileHandler.php';
require_once '../FileHandler/HandlerJson.php';
require_once '../FileHandler/HandlerSerialization.php';
require_once '../FileHandler/HandlerCsv.php';
require_once 'transacciones.php';
require_once 'filemanager.php';
require_once 'log.php';

$log = new LogEvent;
$actualTime = date("F j Y g:i a", time());

    
    $manager = new FileManager(false, 'transacciones', $_GET["handlerType"]);
    $transaction = $manager->GetById($_GET["transactionId"]);

    if(isset($_GET["transactionId"])){

        $idDeleteElement = $manager->Delete($transaction) + 1;
    }

    if($_POST["handlerType"] == 'HandlerJson'){
        $log->WriteLog("La transaccion #". $idDeleteElement.' fue eliminada el : '.$actualTime.' en JSON');
    }elseif($_POST["handlerType"] == 'HandlerSerialization'){
        $log->WriteLog("La transaccion #". $idDeleteElement.' fue eliminada el : '.$actualTime.' en Serializacion');
    }else{
        $log->WriteLog("La transaccion #". $idDeleteElement.' fue eliminada el : '.$actualTime.' en CSV');
    }

    header("Location: ../index.php");
    exit();

?>

?>