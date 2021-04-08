<?php
    class LayoutTest{

        private $isRoot;

        public function __construct($isRoot = false){
            $this->IsRoot = $isRoot;
        }

    function PrintHeader(){
        $directory = ($this->IsRoot) ? "" : "../";

        $header = <<<EOF

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{$directory}assets/css/style.css">
    
    <video autoplay muted loop id="videoBack">
      <source src="{$directory}resource/background3.mp4" type="video/mp4">
    </video>
    

    <title>Segundo parcial</title>
</head>
<body>

<div class="content"></div>

    <!-- Navbar -->
    <nav class="navbar bg-dark">
      <span class="navbar-text nav_title">
        <a href="{$directory}index.php" class="hyper_text">
        <img src="{$directory}resource/senko_ico.png" alt="" width="50" height="48" class="d-inline-block align-top">
            Segundo parcial
        </a>
      </span>
    </nav> 

    

EOF;

        echo $header;
    }

    function PrintFooter(){
        $directory = ($this->IsRoot) ? "" : "../";
        $footer = <<<EOF
        
    

        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="{$directory}assets\js\Jquery\jquery-3.5.1.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{$directory}assets\js\main\index.js"></script>

</body>

</html>

EOF;

        echo $footer;
    }
}

?>