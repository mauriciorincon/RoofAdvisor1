<?php

class termsconditionsController{

    function __construct()
	{		
    }
    
    public function showinfo(){
		require_once("vista/head.php");
		require_once("vista/termsconditions.php");
		require_once("vista/footer.php");
    }

    public function privacyinfo(){
		require_once("vista/head.php");
		require_once("vista/privacy.php");
		require_once("vista/footer.php");
    }
    
}
?>