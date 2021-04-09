<?php 
require_once 'layout/main.php';
require_once 'HandyActions/utilities.php';
require_once 'FileHandler/MFileHandler.php'; 
require_once 'FileHandler/PFileHandler.php';
require_once 'FileHandler/HandlerJson.php';
require_once 'FileHandler/HandlerSerialization.php';
require_once 'FileHandler/HandlerCsv.php';
require_once 'actions/transacciones.php';
require_once 'actions/filemanager.php';
require_once 'actions/log.php';

$myLog = new LogEvent();

$myLog->CreateLog();
$log = $myLog->ReadLog();
$log = explode(",", $log);

$handler = null;

if(isset($_GET['test'])){

}

if(isset($_GET['error'])){
    if($_GET['error'] == 'true'){
        echo "<input type='hidden' id='errorHandler'";
    }
}

if(isset($_GET["manejoId"])){
    if($_GET["manejoId"] == 1){
        $handler = 'HandlerJson';
    }else if($_GET["manejoId"] == 2){
        $handler = 'HandlerSerialization';
    }else if($_GET["manejoId"] == 3){
        $handler = 'HandlerCsv';
    } 
}else{
    $handler = 'HandlerJson';
}

$layout = new LayoutTest(true);
$manager = new FileManager(true, 'transacciones', $handler);

$transactions = $manager->GetList();

?>

<?php echo $layout->PrintHeader();?>

<div class="col-sm-12">
    <div class="card card_fix3">
        <div class="card-header">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php if($handler == 'HandlerSerialization'): ?>
                        Manejar en base a: Serializacion con txt
                    <?php elseif($handler == 'HandlerCsv'): ?>
                        Manejar en base a: CSV
                    <?php else: ?>
                        Manejar en base a: Json
                    <?php endif; ?>
                    
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="index.php?manejoId=1">Json</a></li>
                    <li><a class="dropdown-item" href="index.php?manejoId=2">Serialization (txt)</a></li>
                    <li><a class="dropdown-item" href="index.php?manejoId=3">Csv</a></li>
                </ul>
            </div>
        </div>    


        <div class="card-header">
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nueva-transaccion">
                Agregar nueva transaccion
            </button>

            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#subir-transaccion">
                Subir listado de transacciones
            </button>

            <button type="button" class="btn btn-info" id="btn-show-toastr" data-bs-toggle="modal" data-bs-target="#modal-log">
                Ver log de eventos
            </button>
            

        </div>

        <div class="card-body">
            <div class="row">
            
                <table class="table" id ="content-container">
                <thead>
                    <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Fecha y Hora</th>
                    <th scope="col">Monto</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                <?php if(count($transactions) == 0): ?>
                    <tr>
                        <td>0</th>
                        <th></th>
                        <th></th>
                        <td>No se encontraron trasacciones</th>
                    </tr>
                <?php else: ?>
                    <?php foreach($transactions as $transaction) : ?>
                        <tr>
                        <th scope="row"><?= $transaction->Id?></th>
                        <td><?= $transaction->Fecha?></td>
                        <td><?= $transaction->Monto?></td>
                        <td><?= $transaction->Descripcion?></td>

                        <td>
                            <a href="actions/edit.php?transactionId=<?= $transaction->Id?>&handlerType=<?= $handler?>" class="btn btn-warning">Editar</a>
                            <a href="#" data-handler="<?= $handler?>" data-id="<?= $transaction->Id?>" id="btn-delete" class="btn btn-danger">Eliminar</a>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                    
                </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
    <div class="modal fade" id="nueva-transaccion" tabindex="-1" aria-labelledby="firstModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="firstModal">Agregar Transaccion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="actions/add.php" method="POST">
                    
                        <div class="form-floating mb-3">
                            <input type="text" name="CantidadMonto" class="form-control" id="pelicula" placeholder="Juan">
                            <label for="nombre">Monto</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="DescripcionMonto" class="form-control" id="pelicula" placeholder="Perez">
                            <label for="nombre">Descripcion</label>
                        </div>

                        <input type="hidden" name="handlerType" value="<?= $handler?>">

                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Segundo Modal -->
    <div class="modal fade" id="subir-transaccion" tabindex="-1" aria-labelledby="firstModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="firstModal">Subir Transaccion (Solo JSON o CSV. Asegurarse de que la extension coincida con el manejador)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="actions/add.php" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Seleccionar fichero</label>
                            <input class="form-control" name="archivo" type="file" id="formFile">
                        </div>

                        <input type="hidden" name="handlerType2" value="<?= $handler?>">
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Tercer Modal -->
    <div class="modal fade" id="modal-log" tabindex="-1" aria-labelledby="firstModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="firstModal">Log de eventos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <ol class="list-group list-group-numbered mb-4">
                    <?php foreach($log as $value => $logs):?>
                                    
                        <li class="list-group-item"><?= $logs?></li>

                    <?php endforeach;?>

                    </ol>
                    
                </div>
            </div>
        </div>
    </div>

    

<?php echo $layout->PrintFooter();?>