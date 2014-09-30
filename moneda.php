<?php 

	
	$archivo = file_get_contents("moneda.json");

	$data = json_decode($archivo, true);

	var_dump($data["EUR"]);



// no cerrar el php