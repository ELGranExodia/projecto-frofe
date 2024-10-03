<?php

    // Asignamos un nombre de espacio para nuestro controlador
    namespace App\Controllers;

    class Controller {
        /*
            Método para cargar nuestras vistas desde el controlador
            Recibimos 2 parametros:
            1. La ruta donde se encuentra y el nombre de nuestra vista
            2. Parametros adicionales que se mostrarán en la vista
        */
        public function view($route, $data = []) {
            // Destructuramos el array para crear variables
            extract($data);
            
            // Verificamos si el archivo de vista existe
            if(file_exists("../app/views/{$route}.php")) {
                // Incluimos el archivo de nuestra vista pero sin incrustarlo directamente en la ejecución
                // para guardarlo en la variable $content, y posteriormente, retornarlo como un string
                ob_start();
                include "../app/views/{$route}.php";
                $content = ob_get_clean();
            
                return $content;
            } else
                return "404 not found";
        }
    }
