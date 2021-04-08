<?php
require_once '../layout/main.php';
require_once '../HandyActions/utilities.php';
require_once '../FileHandler/MFileHandler.php'; 
require_once '../FileHandler/PFileHandler.php';
require_once '../FileHandler/HandlerJson.php';
require_once '../FileHandler/HandlerSerialization.php';
require_once '../FileHandler/HandlerCsv.php';
require_once 'log.php';
require_once 'transacciones.php';
require_once 'filemanager.php';

$layout = new LayoutTest();
$log = new LogEvent;
$actualTime = date("F j Y g:i a", time());


if (isset($_GET["transactionId"])) {
    $manager = new FileManager(false, 'transacciones', $_GET["handlerType"]);

    $transaction = $manager->GetById($_GET["transactionId"]);
}

if (isset($_POST["CantidadMonto"]) && isset($_POST["DescripcionMonto"])) {
    $manager = new FileManager(false, 'transacciones', $_POST["handlerType"]);

    $transaction = new Trasacciones($_POST["transactionId"], $_POST["transactionFecha"], $_POST["CantidadMonto"], $_POST["DescripcionMonto"]);

    $idEditElement = $manager->Edit($transaction) + 1;

    if($_POST["handlerType"] == 'HandlerJson'){
        $log->WriteLog("La transaccion #". $idEditElement.' fue editada el : '.$actualTime.' en JSON');
    }elseif($_POST["handlerType"] == 'HandlerSerialization'){
        $log->WriteLog("La transaccion #". $idEditElement.' fue editada el : '.$actualTime.' en Serializacion');
    }else{
        $log->WriteLog("La transaccion #". $idEditElement.' fue editada el : '.$actualTime.' en CSV');
    }

    header("Location: ../index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
</head>

<body>

    <?php echo $layout->printHeader() ?>

    <div class="card card_fix2">
    <div class="card-body">
        <div class="card-header">
          Editar trasaction # <?= $transaction->Id?>
        </div>
        <form class="form" action="edit.php" method="POST">

            <input type="hidden" name="transactionId" value="<?= $transaction->Id?>">
            <input type="hidden" name="transactionFecha" value="<?= $transaction->Fecha?>">
            <input type="hidden" name="handlerType" value="<?= $_GET['handlerType']?>">

            <div class="form-floating mb-3">
                <input type="text" name="CantidadMonto" value="<?= $transaction->Monto?>" class="form-control" id="transaccion" placeholder="Pelicula">
                <label for="nombre">Editar Monto</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="DescripcionMonto" value="<?= $transaction->Descripcion?>" class="form-control" id="transaccion" placeholder="Pelicula">
                <label for="nombre">Editar Descripcion</label>
            </div>
            
    <div class="modal-footer">
        <a href="../index.php" class="btn btn-secondary">Close</a>
        <button type="button" class="btn btn-primary btn-edit">Save changes</button>
        <button type="submit" class="btn-hidden" id = "target"></button>
        
    </div>

    </form>
        

    </div>

    <?php echo $layout->printFooter() ?>

</body>

</html>