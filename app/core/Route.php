<?php

    // Asignamos un nombre de espacio a nuestra clase según la carpeta donde se encuentre
    namespace App\Core;

    class Route {
        // Declaramos un array como atributo privado de tipo estático donde procesaremos las rutas de nuestro proyecto
        private static $routes = [];

        // Método estático para establecer las rutas de tipo GET
        // Enviamos 2 parametros: la URL y una función anonima (callback)
        public static function get($uri, $callback) {
            // Eliminamos el carater / que se encuentre al inicio o final de la URL enviada
            $uri = trim($uri, '/');

            // Asignamos al array una nueva posición que será el nombre de la URL y le asignamos el Callback 
            self::$routes['GET'][$uri] = $callback;
        }

        // Método estatico para establecer las rutas de tipo POST
        // Enviamos 2 parametros: la URL y una función anonima (callback)
        public static function post($uri, $callback) {
            // Eliminamos el carater / que se encuentre al inicio o final de la URL enviada
            $uri = trim($uri, '/');

            // Asignamos al array una nueva posición que será el nombre de la URL y le asignamos el Callback
            self::$routes['POST'][$uri] = $callback;
        }

        // Método para recuperar la URL escrita desde la barra de direcciones del navegador y ejecutar la acción
        // asignada en nuestro archivo de rutas (routes.php)
        public static function dispatch() {
            // Recuperamos la URL escrita en la barra de direcciones del navegador y la guardamos en una variable
            $uri = $_SERVER['REQUEST_URI'];

            // Eliminamos el caracter / que se encuentra al inicio o final de la URL
            $uri = trim($uri, '/');

            // Recuperamos de la URL el método utilizado, GET o POST y lo guardamos en una variable
            $method = $_SERVER['REQUEST_METHOD'];

            // Recorremos todas las rutas almacenadas en nuestro array $routes para que se ejecuta la acción establecida
            foreach(self::$routes[$method] as $route => $callback) {
                // Verificamos si en la ruta se encuentra el caracter :
                if(strpos($route, ':') != false)
                    // Comprobamos con una expresión regular si después de los 2 puntos hay un string en la ruta
                    // y lo reemplazamos por otra expresión regular
                    $route = preg_replace('#:[a-zA-Z0-9]+#', '([a-zA-Z0-9]+)', $route);

                // Verificamos si el contenido de la variable $route coincide con la URL escrita utilizando
                // expresiones regulares, y además, guardamos el subpatrón en la variable $matches el cual es un array
                if(preg_match("#^$route$#", $uri, $matches)) {
                    // Generamos un nuevo array a partir del array $matches iniciando del indice 1 y lo guardamos
                    // en la variable $params
                    $params = array_slice($matches, 1);
                    

                    // Verificamos si recibimos una función callback
                    if(is_callable($callback))
                        // Asignamos a al respuesta la función anonima (callback) y enviamos los parametros
                        // desdoblando el array $params en variables
                        $response = $callback(...$params);

                    // Verificamos si recibimos un array en la variable $callback
                    if(is_array($callback)) {
                        // Instanciamos la clase que se encuentra en la primera posición del array
                        $controller = new $callback[0];
                        
                        // Asignamos a la respuesta el método del controlador que se encuentra en la segunda posición
                        //  del array y enviamos los parametros desdoblando el array $params en variables
                        $response = $controller->{$callback[1]}(...$params);
                    }

                    // Verificamos si la variable $response en un array o un objeto
                    if(is_array($response) || is_object($response))
                        // Si es verdadero convertimos la respuesta a formato JSON y pintamos la respuesta en el navegador
                        echo json_encode($response);
                    else
                        // Si es falso solamente pintamos la respuesta en el navegador
                        echo $response;

                    return;
                }
            }
            
            // Si no encuentra ninguna ruta establecida en el archivo routes.php se detiene la ejecución de la aplicación
            // y nos muestra un mensaje de error
            die('404 archivo no encontrado');
        }
    }