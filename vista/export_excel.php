<?php

if(isset($_POST['data'])){
    $_table=$_POST['data'];

    header("Content-Type: application/xls");
	header("Content-Disposition: attachment; filename=listadoContratos.xls");
	echo $_table;
}
?>