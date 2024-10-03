<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="vendor/jqgrid/ui.jqgrid.bootstrap5.css">
    <link rel="stylesheet" href="vendor/alertify/alertify.min.css">
    <link rel="stylesheet" href="vendor/alertify/themes/default.min.css">
    <link rel="stylesheet" href="vendor/formvalidation/formvalidation.min.css">
    <link rel="stylesheet" href="vendor/resources/css/proveedor.css">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="fa-regular fa-star-half-stroke"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">SIACEIN</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="fa-regular fa-user"></i>
                        <span>Proveedores</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="fa-regular fa-rectangle-list"></i>
                        <span>Categorías</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="fa-solid fa-pizza-slice"></i>
                        <span>Productos</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Login</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Register</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="fa-solid fa-gears"></i>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="/" class="sidebar-link">
                    <i class="fa-solid fa-person-walking-arrow-right"></i>
                    <span>Cerrar sesión</span>
                </a>
            </div>
        </aside>
        <div class="main bg-user1">
            <nav class="navbar navbar-expand px-4 py-3">
                <form action="#" class="d-none d-sm-inline-block">

                </form>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="vendor/resources/img/account_circle.svg" class="avatar img-fluid" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded">

                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- Cuerpo principal de la vista Proveedor -->
            <main class="content px-3 py-4">
                <button class="btn btn-outline-primary me-2" onclick="agregar()"><i class="fa-solid fa-plus"></i> Agregar</button>
                <button class="btn btn-outline-primary me-2" onclick="editar()"><i class="fa-solid fa-pen"></i> Modificar</button>
                <button class="btn btn-outline-primary me-2" onclick="eliminar()"><i class="fa-solid fa-trash-alt"></i> Eliminar</button>
                <div class="container-fluid mt-3">
                    <table id="proveedores"></table>
                    <div id="navproveedores"></div>
                </div>
            </main>
            <footer class="footer">
            </footer>
        </div>
    </div>

    <!-- Ventanas Modales -->
    <div id="modalProveedor" class="modal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar/Editar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formProveedor">
                <div class="modal-body">
                    <div class="form-group mb-3 row">
                        <label for="nrc" class="col-md-6 col-form-label">Número de Registro de Contribuyente:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="nrc" name="nrc">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nombre_empresa">Nombre de la empresa:</label>
                        <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa">
                    </div>
                    <div class="form-group mb-3">
                        <label for="razon_social">Razón Social:</label>
                        <input type="text" class="form-control" id="razon_social" name="razon_social">
                    </div>
                    <div class="form-group mb-3 row">
                        <div class="col-md-8">
                            <label for="persona_contacto" class="col-form-label">Persona de contacto:</label>
                            <input type="text" class="form-control" id="persona_contacto" name="persona_contacto">
                        </div>
                        <div class="col-md-4">
                            <label for="telefono_contacto" class="col-form-label">Teléfono de contacto:</label>
                            <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="direccion">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion">
                    </div>
                    <div class="form-group mb-3">
                        <label for="correo_electronico">Correo Electrónico:</label>
                        <input type="text" class="form-control" id="correo_electronico" name="correo_electronico">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery/jquery.js"></script>
    <script src="vendor/jqgrid/grid.locale.es.js"></script>
    <script src="vendor/jqgrid/jquery.jqgrid.min.js"></script>
    <script src="vendor/alertify/alertify.min.js"></script>
    <script src="vendor/formvalidation/formvalidation.min.js"></script>
    <script src="vendor/formvalidation/framework/bootstrap4.min.js"></script>
    <script src="vendor/resources/js/proveedor.js"></script>
</body>

</html>