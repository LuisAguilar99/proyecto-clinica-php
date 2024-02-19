<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: login.php");
} else {
    $idUsuarioIndex = $_SESSION['idUsuario'];
    $empleadoIndex = $_SESSION['idEmpleado'];
    $usuarioIndex = $_SESSION['usuario'];
    $tipoAdminIndex = $_SESSION['tipoAdmin'];
    $dadoBajaIndex = $_SESSION['dadoBaja'];
}
include('./funciones/conecta.php');
?>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Administración</title>

    <!-- Bootstrap core CSS -->
    <script src="./js/jquery-3.6.0.min.js"></script>
    <link href="./css/bootstrap.css" rel="stylesheet" crossorigin="anonymous">
    <link href="./css/jquery.dataTables.min.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="./js/jquery.dataTables.min.js"></script>

    <!-- Favicons -->
    <!-- <link rel="apple-touch-icon" href="/docs/5.1/assets/img/favicons/apple-touch-icon.png" sizes="180x180"> -->

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="./css/dashboard.css" rel="stylesheet">
    <style type="text/css">
        /* Chart.js */

        @keyframes chartjs-render-animation {
            from {
                opacity: .99
            }

            to {
                opacity: 1
            }
        }

        .chartjs-render-monitor {
            animation: chartjs-render-animation 1ms
        }

        .chartjs-size-monitor,
        .chartjs-size-monitor-expand,
        .chartjs-size-monitor-shrink {
            position: absolute;
            direction: ltr;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            pointer-events: none;
            visibility: hidden;
            z-index: -1
        }

        .chartjs-size-monitor-expand>div {
            position: absolute;
            width: 1000000px;
            height: 1000000px;
            left: 0;
            top: 0
        }

        .chartjs-size-monitor-shrink>div {
            position: absolute;
            width: 200%;
            height: 200%;
            left: 0;
            top: 0
        }

        .oculto {
            display: none;
        }


        label {
            display: inline-block;
        }

        .cuadros {
            border: 1px solid grey;
            border: 10.5px outset #E5E8E8;
            border-radius: 5%;
            padding: 15px;
        }

        .cuadros-secc {
            padding: 15px;
            border: 1px inset #E5E8E8;           
        }

        .datosCargados {
            border: 2.5px solid #E5E8E8;
            background-color: #F4F6F7;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
        }
    </style>
    <script>

        $(document).ready(function() {            
            for (var i = 1; i < 4; i++) {
                $('#myTable' + i).DataTable({
                    "lengthMenu": [
                        [4, 25, 50, -1],
                        [4, 25, 50, "All"]
                    ],
                    // "paging": false,
                    "info": false
                });
            }
        });

        function ocultarSeccion(seccion) {
            var listSeccion = ["#nuevoCliente", "#adeudoCliente", "#actualizarCliente", "#mostrarCliente", "#seccionDefault", "#formCorrecto"];
            for (var i = 0; i < listSeccion.length; i++) {
                if (listSeccion[i] == seccion) {
                    $(listSeccion[i]).removeClass("oculto");
                } else {
                    $(listSeccion[i]).addClass("oculto");
                }
            }
        }
   
        function asignarDeuda() {
            var id_cliente = $('#idCliente').val();
            if (id_cliente != '') {
                $.ajax({
                    url: './funciones/asignardeudaCliente.php',
                    type: 'post',
                    dataType: 'text',
                    data: 'id_cliente=' + id_cliente,
                    success: function(res) {
                        if (res == 1) {
                            alert('El adeudo fue asignado');
                            location.reload();
                        } else {
                            alert('El cliente no existe');
                        }
                        return true;
                    },
                    error: function(res) {
                        alert('Error al conectar al servidor...');
                        return false;
                    }
                });
            } else {
                alert("Inserta el id del cliente");
                return false;
            }
        }

        function quitarDeuda() {
            var id_cliente = $('#idCliente').val();
            if (id_cliente != '') {
                $.ajax({
                    url: './funciones/quitardeudaCliente.php',
                    type: 'post',
                    dataType: 'text',
                    data: 'id_cliente=' + id_cliente,
                    success: function(res) {
                        if (res == 1) {
                            alert('El adeudo fue removido');
                            location.reload();
                        } else {

                            alert('El cliente no existe');
                        }                                                                        
                        return true;
                    },
                    error: function(res) {
                        alert(res);
                        alert('Error al conectar al servidor...');
                        return false;
                    }
                });
            } else {
                alert("Inserta el id del cliente");
                return false;
            }
        }       

        function agregarDatos() {
            var nombreCliente = $('#nombreCliente').val();
            var apellidoCliente = $('#apellidoCliente').val();
            var edadCliente = $('#edadCliente').val();
            var telefonoCliente = $('#telefonoCliente').val();
            var correoCliente = $('#correoCliente').val();
            // alert(apellidoCliente);
            if (nombreCliente != '' && apellidoCliente != '' && edadCliente != '' && telefonoCliente != '' && correoCliente != '') {
                $.ajax({
                    url: './funciones/agregarClienteBase.php',
                    type: 'post',
                    data: 'nombreCliente=' + nombreCliente + '&apellidoCliente=' + apellidoCliente + '&edadCliente=' + edadCliente + '&telefonoCliente=' + telefonoCliente + '&correoCliente=' + correoCliente,
                    success: function(res) {
                        if (res) {
                            alert('Datos agregados');
                            ocultarSeccion('#formCorrecto');
                            limpiarForm();
                            
                        } else {
                            alert('Datos NO agregados');
                        }
                        return true;
                    },
                    error: function(res) {
                        console.log(res);
                        alert('Error al conectar al servidor...');
                        return false;
                    }
                });
            } else {
                alert("Inserta el id del cliente");
                return false;
            }
        }

        function limpiarForm() {
            $('#nombreCliente').val('');
            $('#apellidoCliente').val('');
            $('#edadCliente').val('');
            $('#telefonoCliente').val('');
            $('#correoCliente').val('');
            $('#nombreClienteAct').val('');
            $('#apellidoClienteAct').val('');
            $('#edadClienteAct').val('');
            $('#telefonoClienteAct').val('');
            $('#correoClienteAct').val('');
        }

        function cargarDatosAct() {
            var id_cliente = $('#id_cliente').val();
            if (id_cliente != '') {
                $.ajax({
                    url: './funciones/obtenerCliente.php',
                    type: 'post',
                    data: 'id_cliente=' + id_cliente,
                    success: function(res) {
                        if ($.trim(res) != '0') {
                            var datos = res.split("|");                            
                            $('#nombreClienteAct').val(datos[0]);
                            $('#apellidoClienteAct').val(datos[1]);
                            $('#telefonoClienteAct').val(datos[2]);
                            $('#correoClienteAct').val(datos[3]);
                            $('#edadClienteAct').val($.trim(datos[4]));
                            $('#idClienteAct').val(datos[5]);
                            $('#modalActualizar').modal('show');
                        } else {
                            limpiarForm();
                            alert("No se encontro cliente con este ID");    
                        }
                        return true;
                    },
                    error: function(res) {
                        console.log(res);
                        alert('Error al conectar al servidor...');
                        return false;
                    }
                });
            } else {
                alert("Inserta el id del cliente");
                return false;
            }
        }

        function actualizarDatos(){
            var idClienteAct = $('#idClienteAct').val();
            var nombreClienteAct = $('#nombreClienteAct').val();
            var apellidoClienteAct = $('#apellidoClienteAct').val();
            var edadClienteAct = $('#edadClienteAct').val();
            var telefonoClienteAct = $('#telefonoClienteAct').val();
            var correoClienteAct = $('#correoClienteAct').val();
            // alert(apellidoCliente);
            if (idClienteAct != '' && nombreCliente != '' && apellidoCliente != '' && edadCliente != '' && telefonoCliente != '' && correoCliente != '') {
                $.ajax({
                    url: './funciones/actualizarDatosCliente.php',
                    type: 'post',
                    data: 'idClienteAct='+idClienteAct+'&nombreClienteAct=' + nombreClienteAct + '&apellidoClienteAct=' + apellidoClienteAct + '&edadClienteAct=' + edadClienteAct + '&telefonoClienteAct=' + telefonoClienteAct + '&correoClienteAct=' + correoClienteAct,
                    success: function(res) {
                        if (res) {
                            alert('Datos Actualizados');
                            limpiarForm();
                            cerrarModal();
                            
                        } else {
                            alert('Datos NO actualizados');
                            cerrarModal();
                        }
                        
                        return true;
                    },
                    error: function(res) {
                        console.log(res);
                        alert('Error al conectar al servidor...');
                        return false;
                    }
                });
            } else {
                alert("Inserta el id del cliente");
                return false;
            }
        }

        function cerrarModal(){
            $('#modalActualizar').modal('hide');
        }

        function refrescar(){
            $( "#myDivTable3" ).load( "./listarClientesInfo.php" );
            console.log('actualicion');
        }
    </script>
</head>

<body>

    <?php include("./navbar/navbar.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <?php include("./navbar/navbar_seccion.php"); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Panel de administración - Clientes</h1>
                </div>
            </main>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Modal -->
                <div class="row">
                    <div class="col">
                        <div class="container">
                            <div class="row">
                                <div class="col cuadros" style="text-align: center;">
                                    <input type="image" src="./sgv/nuevo_cliente.svg" width="40%" onclick="ocultarSeccion('#nuevoCliente');">
                                    <label>
                                        <h5>Nuevo cliente</h5>
                                    </label>
                                </div>
                                <div class="col cuadros" style="text-align: center;">
                                    <input type="image" src="./sgv/adeudos_cliente.svg" width="40%" onclick="ocultarSeccion('#adeudoCliente');">
                                    <label>
                                        <h5>Adeudos clientes</h5>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col cuadros" style="text-align: center;">
                                    <input type="image" src="./sgv/actualizar_cliente.svg" width="40%" onclick="ocultarSeccion('#actualizarCliente');">
                                    <label>
                                        <h5>Actualizar datos</h5>
                                    </label>
                                </div>
                                <div class="col cuadros" style="text-align: center;">
                                    <input type="image" src="./sgv/lista_cliente.svg" width="40%" onclick="ocultarSeccion('#mostrarCliente');">
                                    <label>
                                        <h5>Mostrar clientes</h5>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="table-responsive cuadros-secc rounded-3"> -->
                    </div>
                    <div class="col" id="seccionDefault">
                        <img src="./LOGO_CU.svg" width="100%" height="100%">
                    </div>

                    <div class="col oculto" id="nuevoCliente">
                        <div class="cuadros-secc rounded-3 border border-3">
                            <form name="forma01" id="forma01">
                                <div class="row">
                                    <div class="col">
                                        <label for="nombreCliente">Nombres</label>
                                        <input type="text" class="form-control" id="nombreCliente" name="nombreCliente" placeholder="Nombres del cliente" required>
                                    </div>
                                    <div class="col">
                                        <label for="apellidoCliente">Apellidos</label>
                                        <input type="text" class="form-control" id="apellidoCliente" name="apellidoCliente" placeholder="Apellidos del cliente" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="edadCliente">Fecha nacimiento</label>
                                            <input type="date" class="form-control" id="edadCliente" name="edadCliente" placeholder="Edad del cliente" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="telefonoCliente">Teléfono</label>
                                            <input type="number" class="form-control" maxl="10" id="telefonoCliente" name="telefonoCliente" placeholder="Teléfono del cliente" required>
                                        </div>
                                    </div>
                            
                                </div>
                                <div class="row">
                                <div class="col">
                                        <label for="correoCliente">Correo</label>
                                        <input type="email" class="form-control" id="correoCliente" name="correoCliente" placeholder="Correo del cliente" required>
                                    </div>
                                </div>  
                                <br>
                                <div class="container">
                                    <div class="row">
                                        <div class="col order-last">
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-outline-success" style="width: 300px;" onclick="if(!agregarDatos()) return false;">Guardar nuevo cliente</button>
                                        </div>
                                        <div class="col order-first">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col oculto" id="formCorrecto">
                        <div class="cuadros-secc rounded-3 border border-3" style="text-align: center;">
                            <div class="alert alert-success" role="alert">
                                <img src="./sgv/correcto_2.svg" width="55%" height="55%">
                                <h3>NUEVO CLIENTE AGREGADO</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col oculto" id="adeudoCliente">

                        <div class="cuadros-secc rounded-3 border border-3">
                            <form name="forma01">
                                <div class="row">
                                    <div class="col">
                                        <input type="number" class="form-control" id="idCliente" nombre="idCliente" placeholder="Id del cliente">
                                    </div>
                                </div>
                                <br>
                                <div class="table-responsive-lg">
                                    <table class="table">
                                        <div class="row">
                                            <div class="col" style="text-align:center;">
                                                <button type="submit" class="btn btn-outline-danger" style="width: 200px;" onclick="if(!asignarDeuda()) return false;">Marcar con adeudo</button>
                                            </div>
                                            <div class="col" style="text-align:center;">
                                                <button type="submit" class="btn btn-outline-success" style="width: 200px;" onclick="if(!quitarDeuda()) return false;">Quitar adeudo</button>
                                            </div>
                                    </table>
                                </div>
                            </form>
                            <!-- tabla -->

                            <!-- fin tabla -->
                        </div>
                        <div class="cuadros-secc rounded-3 border border-3">
                            <div id="divTablaDeudas">
                                <?php include("./listarClientes.php"); ?>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col oculto" id="actualizarCliente">
                        <div class="cuadros-secc rounded-3 border border-3">
                                <div class="row">
                                    <div class="col">
                                        <input type="number" class="form-control" id="id_cliente" name="id_cliente" placeholder="Id del cliente">
                                    </div>
                                </div>
                                <br>
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                        </div>
                                        <div class="col">
                                        </div>
                                        <div class="col">
                                        </div>
                                        <div class="col">
                                            <button type="button" class="btn btn-outline-success" style="width: 300px;" onclick="cargarDatosAct();">Cargar registro de cliente</button>
                                        </div>
                                        <div class="col">
                                        </div>
                                        <div class="col">
                                        </div>
                                        <div class="col">
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="cuadros-secc rounded-3 border border-3">
                            <?php include("./listarClientesAct.php"); ?>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-labelledby="modalActualizarLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalActualizarLabel">Actualizar Datos</h5>                                       
                                    </div>
                                    <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" id="idClienteAct" name="idClienteAct">
                                    <div class="col">
                                        <label">Nombres</label>
                                        <input type="text" class="form-control" id="nombreClienteAct" name="nombreClienteAct" placeholder="Nombres del cliente" required>
                                    </div>
                                    <div class="col">
                                        <label>Apellidos</label>
                                        <input type="text" class="form-control" id="apellidoClienteAct" name="apellidoClienteAct" placeholder="Apellidos del cliente" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Fecha nacimiento</label>
                                            <input type="date" class="form-control" id="edadClienteAct" name="edadClienteAct" placeholder="Fecha nacimiento del cliente" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Teléfono</label>
                                            <input type="number" class="form-control" maxl="10" id="telefonoClienteAct" name="telefonoClienteAct" placeholder="Teléfono del cliente" required>
                                        </div>
                                    </div>
                                   
                                </div>    
                                <div class="row">
                                <div class="col">
                                        <label>Correo</label>
                                        <input type="email" class="form-control" id="correoClienteAct" name="correoClienteAct" placeholder="Correo del cliente" required>
                                    </div>
                                </div>                                      
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" onclick="cerrarModal()">Cancelar</button>
                                        <button type="button" class="btn btn-primary" onclick="actualizarDatos()">Guardar cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col oculto" id="mostrarCliente">
                        <div class="cuadros-secc rounded-3 border border-3" id="myDivTable3">
                            <?php include("./listarClientesInfo.php"); ?>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script src="./js/bootstrap.js" crossorigin="anonymous"></script>
    <script src="./js/active.js"></script>   
</body>

</html>