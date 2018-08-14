<?php

class faqController{

    function __construct()
	{		
    }
    
    public function showinfo(){
		require_once("vista/head.php");
		require_once("vista/Faq.php");
		require_once("vista/footer.php");
    }
   
    
}
?>