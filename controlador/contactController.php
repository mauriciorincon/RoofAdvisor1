<?php

class contactController{

    function __construct()
	{		
    }
    
    public function showinfo(){
		require_once("vista/head.php");
		require_once("vista/contact.php");
		require_once("vista/footer.php");
    }
    
}
?>