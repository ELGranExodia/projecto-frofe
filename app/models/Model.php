<?php

    namespace App\Models;

    // Importamos la clase Mysqli de PHP para realizar la conexión con la base de datos
    use mysqli;

    class Model {

        /*  
            Establecemos los atributos para realizar la conexión con la base de datos
            $db_host: nombre del servidor
            $db_user: nombre del usuario de la base de datos
            $db_pass: conraseña de la base de datos
            $db_name: nombre de la base de datos
        */
        protected $db_host = DB_HOST;
        protected $db_user = DB_USER;
        protected $db_pass = DB_PASS;
        protected $db_name = DB_NAME;

        // Atributo para guardar la conexión
        protected $connection;

        // Atributo donde almacenamos el nombre de la tabla de la base de datos a utilizar
        protected $table;

        // Atributo donde guardaremos la consulta ejecutada en MySQL
        protected $query;

        // Constructor de la clase que nos devuelve la conexión a la base de datos
        public function __construct() {
            $this->connection();
        }

        // Método para establecer la conexión con la base de datos
        public function connection() {
            // Almacenamos en el atributo connection la conexión a nuestra base de datos
            // instanciando la clase mysqli
            $this->connection = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

            // Si existe un error al establecer la conexión entonces detenemos la ejecución de la aplicación
            // y mostramos el mensaje de error
            if($this->connection->connect_error)
                die('Error de conección: ' . $this->connection->connect_error);
        }

        // Método para ejecutar nuestras consultas SQL
        public function query($sql) {
            // Ejecutamos la consulta y la guardamos en el atributo query
            $this->query = $this->connection->query($sql);

            // Devolvemos el objeto
            return $this;
        }

        // Método que nos devuelve el primer registro de la consulta SQL
        public function first() {
            return json_decode(json_encode($this->query->fetch_assoc()));
        }

        // Método que nos devuelve todos los registros de la consulta SQL
        public function get() {
            return json_decode(json_encode($this->query->fetch_all(MYSQLI_ASSOC)));
        }

        // Método que se encarga de ejecutar la consulta SQL de la tabla asociada y nos devuelve todos los registros
        public function all() {
            $sql = "SELECT * FROM $this->table";
            return $this->query($sql)->get();
        }

        /*  
            Método que se encarga de filtrar la información en la consulta SQL
            Parametros recibidos:
            $column: nombre de la(s) columna(s) por la que se realizara el filtro. Puede ser un valor normal o un array
                     asociativo. Además, en el podremos indicar operadores de relación.
            $value: valor de la(s) columna(s)
        */
        public function where($column, $value = null) {
            $sql = "SELECT * FROM $this->table WHERE ";

            if(is_array($column)) {
                /*
                    Si el parametro $column es un array, recorremos el arreglo para preparar la expresión del where
                    Por ejemplo, si enviamos: ['id>' => 2, 'name' => 'Joe', 'title' => 'boss']
                    se concatenara a la variable $sql: id > 2 AND name = 'Joe' AND title = 'boss'.
                */
                foreach($column as $key => $value) {
                    $operador = strpbrk($key,'<>=!');
                    echo $operador;
                    if(in_array($operador, ['<','>','<=','>=','=','!=']))
                        $sql .= "$key '$value' AND ";
                    else if(empty($operador))
                        $sql .= "$key = '$value' AND ";
                    else
	                    break;
                }
                $sql = trim($sql, ' AND ');
            } else {
                /*
                    Si el parametro $column no es un array, preparamos una simple expresión where
                    con los parametros $column y $value.
                    Por ejemplo, si enviamos: ('id>', 2) se concatenara a la variable $sql: id > 2
                */
                $operador = strpbrk($column,'<>=!');
                if(in_array($operador, ['<','>','<=','>=','=','!=']))
                    $sql .= "$column '$value'";
                else if(empty($operador))
                    $sql .= "$column = '$value'";
            }

            // Ejecutamos la consulta SQL
            $this->query($sql);

            // Devolvemos el objeto
            return $this;
        }

        /*
            Método para insertar registros en la tabla
            El parametro $data debe ser un array asociativo
        */
        public function insert($data) {
            // Guardamos la claves del array asociativo, y cada valor, lo separamos por comas
            $columns = array_keys($data);
            $columns = implode(', ', $columns);

            // Guardamos los valores del array asociativo, y cada uno de ellos, lo separamos por comillas simples y comas
            $values = array_values($data);
            $values = "'" . implode("', '", $values) . "'";

            // Preparamos la consulta SQL
            $sql = "INSERT INTO $this->table ($columns) VALUES ($values)";

            // Ejecutamos la consulta
            $this->query($sql);

            // Devolvemos el id del registro insertado en la tabla
            return $this->connection->insert_id;
        }

        /*
            Método para actualizar datos de un registro en la tabla
            Los parametros $data y $where deben ser de tipo array asociativo
        */
        public function update($data, $where) {
            $fields = [];

            // Recorremos el array $data para guardar en el arreglo $fields los campos y valores a modificar
            foreach($data as $key => $value)
                $fields[] = "$key = '$value'";

            // Separamos con comas los valores del array $fields
            $columns = implode(', ',$fields);

            // Preparamos la consulta SQL
            $sql = "UPDATE $this->table SET $columns";

            // Preparamos el WHERE de la consulta
            $column = implode(array_keys($where));
            $value = implode(array_values($where));
            $operador = strpbrk($column,'<>=');
            if(in_array($operador, ['<','>','<=','>=','=']))
                $sql .= " WHERE $column $operador '$value'";
            else
                $sql .= " WHERE $column = '$value'";

            // Ejecutamos la consulta
            $this->query($sql);
        }

        // Método para eliminar registros de la tabla
        public function delete($where) {
            // Preparamos la consulta SQL
            $sql = "DELETE FROM $this->table";

            // Preparamos el WHERE de la consulta
            $column = implode(array_keys($where));
            $value = implode(array_values($where));
            $operador = strpbrk($column,'<>=');
            if(in_array($operador, ['<','>','<=','>=','=']))
                $sql .= " WHERE $column $operador '$value'";
            else
                $sql .= " WHERE $column = '$value'";

            // Ejecutamos la consulta
            $this->query($sql);
        }

    }
