<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/resources/css/home.css">
</head>
<body class="vh-100 bg-primary">
    <div class="container h-100">
        <div class="row h-100">
            <div class="d-none d-md-block col-md-7 align-self-center">
                <img src="vendor/resources/img/almacen.png" class="img-fluid">
            </div>
            <div class="col-md-5 px-5 align-self-center">
                <div class="card px-4">
                    <div class="card-body">
                        <form id="formLogin">
                            <h3 class="text-center mb-3">SISTEMA DE CONTROL<br>DE ALMACEN</h3>
                            <h4 class="text-center mb-3">INICIO DE SESIÓN</h4>
                            <div class="mb-3">
                                <label for="user">Usuario:</label>
                                <input type="text" id="user" name="user" class="form-control">
                                <div class="invalid-feedback">
                                    Usuario incorrecto
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password">Contraseña:</label>
                                <input type="password" id="password" name="password" class="form-control">
                                <div class="invalid-feedback">
                                    Contraseña incorrecta
                                </div>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-outline-primary fw-bold">INGRESAR</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery/jquery.js"></script>
    <script src="vendor/resources/js/login.js"></script>
</body>
</html>
