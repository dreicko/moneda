<?php 
	
	header('Content-Type: text/html; charset=UTF-8');

/**
 * Función utilizada para leer el archivo json en la api currency-api y realizar la conversion de moneda.
 * $cadena_de_entrada variable utilizada para leer la moneda y los codigos iso
 * @param  string $cadena_de_entrada es la cantida a convertir junto con las divisas separadas por espacios 
 * @param  string $moneda1 es la divisa origen a convertir 
 * @param  string $moneda2 es la divisa destino a convertir 
 * @return  float Es la conversión de divisas redondeada a dos decimales
 */
	function leer_archivo($cadena_de_entrada, $moneda1, $moneda2){
		// Variable utilizada para tomar el resultado de conversion de moneda
		$resultado = 0.0;
		// Variable igualizada para leer la direccion url de la api
		$url = "http://currency-api.appspot.com/api/". $moneda1 ."/".$moneda2.".json?key=f99cfa4c5097f3ae7c7e23525f28b06bb7ab78f2";
		// Variable para leer el json
		$archivo = file_get_contents($url);
		// Variable igualizada a la función json_decode para devolver un arreglo del json.
		$data = json_decode($archivo);
		// Variable igualizada a la función explode para crear un arreglo de una variable de cadena
		$leer_cadena = explode(' ', $cadena_de_entrada);

		// Declaracion del arreglo con indices asociativos
		$moneda = $leer_cadena[0];
		$pais1 = $leer_cadena[1];
		$pais2 = $leer_cadena[2];

		/** Anidación de la Función para utilizar los parametros enviados a la api
		*	y asi comprobar que los paises no sean iguales
		*/
		revisar_pais($moneda1, $moneda2);

		// Condicional utilizada para verificar que los datos enviados a la api no esten vacios o existan
		if ($moneda > 0 && !empty($data->target || $data->source)) {
			// Condicional anidada para verificar que los datos enviados sean iguales
			if ($pais1 === $data->source && $pais2 === $data->target) {
			// Operaciones a realizar cuando pasa las verificaciones
			$resultado = $moneda * $data->amount;
			// Redondea los decimales del resultado a dos .00
			$resultado = round($resultado, 2);
			// Mensaje de salida con los datos solicitados
			echo ("$moneda $pais1 = $resultado $pais2 (Tasa de conversión: 1 $pais1 = $data->amount $pais2)");
			}

		}else{
			// Mensaje de error en caso de que un codigo ISO 4217 sea incorrecto	
			echo ("El codigo $pais1 o $pais2 no es correcto por favor reviselo");
		}
		
		// Devuelve la conversión redondeada con dos decimales
		return $resultado;

	}
	/**
	 * Prueba unitaria para revisar que la conversión este correcta
	 * @param  string $monto recibe la cantidad a convertir y las divisas de entrada
	 * @param  string $resultado recibe el resultado de la divisa convertida
	 * @return string Escribe en la pagina . si es correcto o ! si es incorrecto
	 */
	function revisar_prueba($monto, $resultado){
		if($monto === $resultado){
		// Simbolo utilizado cuando la prueba pasa
		echo ("."); 
		}else{
		// Simbolo utilizado cuando la prueba no pasa
		echo ("!"); 
		}
	}	

	/**
	 * Prueba unitaria utilizada para revisar que los paises no sean iguales
	 * @param  string $pais_entrada recibe el pais de entrada
	 * @param  string $pais_salida recibe el pais de conversión 
	 * @return string Escribe en la pagina un mensaje segun sea la validación
	 */
	function revisar_pais($pais_entrada, $pais_salida){
		// Condicional utilizada para comprobar que los paises sean diferentes
		if($pais_entrada !== $pais_salida){
			// Mensaje a mostrar cuando es correcto
			echo ("La conversión entre paises es:");
			echo "</br>";
		}else{
			// Mensaje a mostrar cuando es incorrecto
		echo ("Los codigos a convertir son iguales");
		}
		
	}

	/**
 	* Función utilizada para revisar las pruebas de conversión
 	* las conversiones encontradas entre la api y la pagina de currencytools tienen diferencias de centavos entre si
 	* @return string Muestra en la pagina los mensajes segun el resultado
 	*/
	function convertir_moneda(){

		// Conversiones principales
		
		leer_archivo("125.34 MXN USD", "MXN", "USD");
		echo"</br></br>";
		leer_archivo("21536.10 EUR MXN", "EUR", "MXN");
		echo "</br></br>";
		leer_archivo("20.10 EUR XYZ", "EUR", "XYZ");

		// Conversiones sugeridas
		echo "</br></br>";
		// La conversión entre dolares y pesos es diferente en la api y la pagina
		revisar_prueba(leer_archivo("10 USD MXN", "USD", "MXN"), 134.34);
		echo "</br></br>";
		revisar_prueba(leer_archivo("5.5 USD EUR", "USD", "EUR"), 4.35);
		echo "</br></br>";
		revisar_prueba(leer_archivo("20.36 CAD USD", "CAD", "USD"), 18.32);
		echo "</br></br>";
		// Se revisa que los paises enviados a la api sean diferentes
		revisar_pais(leer_archivo("16.45 CAD USD", "CAD", "CAD"));
		echo "</br></br>";
		// Los codigos de algunos paises no estan almacenados en la api
		revisar_prueba(leer_archivo("26.60 ANG BBD", "ANG", "BBD"), 28.84);
	}
	
	// Devuelve todas las pruebas hechas
	convertir_moneda();


?>