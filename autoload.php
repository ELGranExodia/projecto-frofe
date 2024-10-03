<?php

	// Realizamos la autocarga de los archivos de clase cada vez que utilicemos el comando use
	spl_autoload_register(function($clase) {
		/*
			Preparamos la ruta donde se encuentra nuestro archivo de clase
			1. Con ../ nos salimos de la carpeta donde nos encontramos (public)
			2. Reemplazamos el caracter '\' por '/' que se encuentra en la variable $clase
			3. Con .php establecemos la extensión de nuestro archivo
			4. Concatenamos los valores y los guardamos en la variable $ruta
		*/
		$ruta = '../' . str_replace("\\", "/", $clase) . ".php";

		// Verificamos si el archivo existe
		if(file_exists($ruta))
			// Si existe lo importamos
			require_once $ruta;
		else
			// Si no existe, detenemos la ejecución de la apliación y mostramos un mensaje de error
			die("No se pudo cargar la clase $clase");
	});
	