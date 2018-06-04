<?php

class servicesController{

    function __construct()
	{		
    }
    
    public function showinfo(){
		require_once("vista/head.php");
		require_once("vista/services.php");
		require_once("vista/footer.php");
    }
    
}
?>