<?php

    namespace App\Controllers;

    use App\Models\UserModel;

    class LoginController extends Controller {

        protected $modelo;

        public function __construct() {
            $this->modelo = new UserModel();
        }

        public function index() {
            return $this->view('login');
        }

        // Método para verificar las credenciales al momento de loguearse
        public function verify() {
            // Guardamos en las variables $user y $password
            // los valores enviados desde el formulario utilizando el método POST
            $user = $_POST['user'];
            $password = $_POST['password'];

            // Ejecutamos la consulta para obtener el registro del usuario
            $data = $this->modelo->where('user',$user)->first();

            // Verificamos si la contraseña enviada desde el formulario
            // coincide con la que se encuentra en la tabla
            if($data) {
                if($data->password == $password)
                    echo json_encode(['res'=>true]);
                else
                    echo json_encode(['res'=>false,'errpass'=>'Contraseña incorrecta']);
            } else
                echo json_encode(['res'=>false,'erruser'=>'Usuario incorrecto']);
        }

    }
