<?php

class aboutusController{

    function __construct()
	{		
    }
    
    public function showinfo(){
		require_once("vista/head.php");
		require_once("vista/aboutus.php");
		require_once("vista/footer.php");
    }
    
}
?>