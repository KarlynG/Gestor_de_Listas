<?php

    Class Trasacciones{

        public $Id;
        public $Fecha;
        public $Monto;
        public $Descripcion;

        public function __construct($id, $fecha, $monto, $descripcion){
            $this->Id = $id;
            $this->Fecha = $fecha;
            $this->Monto = $monto;
            $this->Descripcion = $descripcion;
         
        }

    }

?>