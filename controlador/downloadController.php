<?php

class downloadController{

    function __construct()
	{		
    }
    
    public function showinfo(){
		require_once("vista/head.php");
		require_once("vista/download.php");
		require_once("vista/footer.php");
    }
    
}
?>