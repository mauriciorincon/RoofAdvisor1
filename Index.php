<?php
if(!isset($_GET['controller']))
{
    require_once("vista/head.php");
    require_once("vista/begin.php");
    require_once("vista/footer.php");
}
else
{

    // Obtenemos el controlador que queremos cargar
    $controller = strtolower($_GET['controller']);

    $accion = isset($_GET['accion']) ? $_GET['accion'] : 'Index';
    
    
    // Instanciamos el controlador
    if (file_exists("controlador/".$controller."Controller.php")){
        
        require_once "controlador/".$controller."Controller.php";
		//echo "carga el controlador";
    }else{
        echo "Contralador no existe "."controlador/".$controller."Controller.php";
    }
    

    $controller = ucwords($controller) . 'controller';

    $controller = new $controller;


    // Llama la accion
    call_user_func( array( $controller, $accion ) );
}
?>
