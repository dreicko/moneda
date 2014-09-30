<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php 
	

	$archivo = file_get_contents("moneda.json");
	$data = json_decode($archivo, true);
	//var_dump($data);
	//print_r($data);
	//echo(1 . $data["source"] . "=" . $data["amount"] ." ". $data["target"]);

	$cadena_de_entrada = "125.34 MXN USD";

	$convertir = explode(' ', $cadena_de_entrada);

	$moneda = $convertir[0];
	$valor_1 = $convertir[1];
	$valor_2 = $convertir[2];

	// Prueba 1 obtener la conversión de manera manual.
	echo ("$moneda $valor_1 = " . $moneda * 0.074 . " $valor_2 (Tasa de conversión: 1 $valor_1 = 0.074 $valor_2)");
	
	// Prueba 2 obtener la conversion con el json.
	$cadena_de_entrada2 = "21536.10 EUR MXN";
	$convertir2 = explode(' ', $cadena_de_entrada2);

	$moneda1 = $convertir2[0];
	$pais1 = $convertir2[1];
	$pais2 = $convertir2[2];
	echo "<br><br>";
	echo ("$moneda1 $data[source] " . $moneda1 * $data["rate"] . " = $data[target] \n (Tasa de conversion: 1 $pais1 = 16.9522 $pais2) ");
	

?>

