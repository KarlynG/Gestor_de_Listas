<?php

    Class FileManager{

        public $fileHandler;
        public $directory;
        public $filename;
        private $utilities;

        public function __construct($isRoot = false, $MyFileName, $handler){

        $prefijo = ($isRoot) ? "actions/" : "";
        $this->directory = "{$prefijo}Mis Transacciones";
        $this->filename = $MyFileName;
        $this->utilities = new Utilities();
        $this->fileHandler = new $handler($this->directory,$this->filename);
    }

    public function Add($item, $isNewFile = false){

        $transactions = $this->GetList();

        if($isNewFile){
            
            foreach($item as $NewTransactions){
                if(count($transactions) == 0){
                    $newItem = new Trasacciones(1, date("F j, Y, g:i a", time()), $NewTransactions->Monto, $NewTransactions->Descripcion);
                    
                }else{
                    $newItem = new Trasacciones(0, date("F j, Y, g:i a", time()), $NewTransactions->Monto, $NewTransactions->Descripcion);
                    $lastElement = $this->utilities->getLastElement($transactions);
                    $newItem->Id = $lastElement->Id + 1;
                }

                array_push($transactions, $newItem);
            }
            $this->fileHandler->SaveFile($transactions);

        }else{

            if(count($transactions) == 0){
                $item->Id = 1;
            }else{
                $lastElement = $this->utilities->getLastElement($transactions);

                $item->Id = $lastElement->Id + 1;
                $lastId = $lastElement->Id + 1;
            }

            array_push($transactions, $item);

            $this->fileHandler->SaveFile($transactions);

            return($lastId);

        }

    }
    

    public function Edit($item){      

        $transactions = $this->GetList();
        
        $index = $this->utilities->getIndexElement($transactions,"Id",$item->Id);

        if($index !== null){
            $transactions[$index] = $item;

            $this->fileHandler->SaveFile($transactions);
        }         
        return($index);
    }

    public function Delete($item){
        $transactions = $this->GetList();
        
        $index = $this->utilities->getIndexElement($transactions,"Id",$item->Id);

        if(count($transactions) > 0){
            unset($transactions[$index]);

            $this->fileHandler->SaveFile($transactions);
        }

        return($index);

    }

    public function GetList(){

        $transactions = $this->fileHandler->ReadFile();
        
        if ($transactions == false) {          
            return array();
        }

        return (array)$transactions;
    }
    
    public function GetById($id){

        $transactions = $this->GetList();

        $transac = $this->utilities->searchProperty($transactions,"Id",$id);     
        
        return $transac[0];
    }  
   


    }

?>