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

            $("#modalActualizar").on('hidden.bs.modal', function () {
                $("#con_titulo_act").prop('checked', false);
                $("#con_cedula_act").prop('checked', false);
                $('#id_empleado_act').val('');
    });
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

        function asignarBaja() {
            var id_empleado = $('#id_empleado_baja').val();
            if (id_empleado != '') {
                $.ajax({
                    url: './funciones/asignarBajaEmpleado.php',
                    type: 'post',
                    dataType: 'text',
                    data: 'id_empleado=' + id_empleado,
                    success: function(res) {
                        if (res == 1) {
                            alert('La baja fue asignada');
                            location.reload();
                        } else {
                            alert('El empleado no existe');
                        }
                        return true;
                    },
                    error: function(res) {
                        alert('Error al conectar al servidor...');
                        return false;
                    }
                });
            } else {
                alert("Inserta el id del empleado");
                return false;
            }
        }

        function removerBaja() {
            var id_empleado = $('#id_empleado_baja').val();
            if (id_empleado != '') {
                $.ajax({
                    url: './funciones/quitarBajaEmpleado.php',
                    type: 'post',
                    dataType: 'text',
                    data: 'id_empleado=' + id_empleado,
                    success: function(res) {
                        if (res == 1) {
                            alert('La baja fue removida');
                            location.reload();
                        } else {

                            alert('El empleado no existe');
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
                alert("Inserta el id del empleado");
                return false;
            }
        }

        function agregarDatos() {
            var nombre_agr = $('#nombre_agr').val();
            var apellidos_agr = $('#apellidos_agr').val();
            var rfc_correo_agr = $('#rfc_correo_agr').val();
            var tipo_admin_agr = $('#tipo_admin_agr').val();
            var con_titulo_agr;
            var con_cedula_agr;
            var sueldo_empleado_agr = $('#sueldo_empleado_agr').val();
            var fecha_laborar_agr = $('#fecha_laborar_agr').val();
            if ($('#con_titulo_agr').prop('checked')) {
                con_titulo_agr = 'on';
            } else {
                con_titulo_agr = 'off';
            }
            if ($('#con_cedula_agr').prop('checked')) {
                con_cedula_agr = 'on';
            } else {
                con_cedula_agr = 'off';
            }
            if (sueldo_empleado_agr != '' && fecha_laborar_agr != '' && nombre_agr != '' && apellidos_agr != '' && rfc_correo_agr != '' && tipo_admin_agr != '' && con_cedula_agr != '' && con_titulo_agr != '') {
                $.ajax({
                    url: './funciones/agregarEmpleadoBase.php',
                    type: 'post',
                    data: 'nombre_agr=' + nombre_agr + '&apellidos_agr=' + apellidos_agr + '&rfc_correo_agr=' + rfc_correo_agr + '&tipo_admin_agr=' + tipo_admin_agr + '&con_cedula_agr=' + con_cedula_agr + '&con_titulo_agr=' + con_titulo_agr + '&sueldo_empleado_agr=' + sueldo_empleado_agr + '&fecha_laborar_agr=' + fecha_laborar_agr,
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
                alert("Inserte datos completos");
                return false;
            }
        }

        function limpiarForm() {
            $('#nombre_agr').val('');
            $('#apellidos_agr').val('');
            $('#rfc_correo_agr').val('');
            $('#tipo_admin_agr').val('');
            $('#sueldo_empleado_agr').val('');
            $('#fecha_laborar_agr').val('');
            $("#con_titulo_agr").prop('checked', false);
            $("#con_cedula_agr").prop('checked', false);
        }

        function cargarDatosAct() {
            var id_empleado_act = $('#id_empleado_act').val();
            if (id_empleado_act != '') {
                $.ajax({
                    url: './funciones/obtenerEmpleado.php',
                    type: 'post',
                    data: 'id_empleado_act=' + id_empleado_act,
                    success: function(res) {
                        if (res) {
                            var datos = $.trim(res).split("|");
                            $('#nombre_act').val(datos[0]);
                            $('#apellidos_act').val(datos[1]);
                            $('#rfc_correo_act').val(datos[2]);
                            $('#tipo_admin_act').val(datos[3]);
                            $('#fecha_laborar_act').val(datos[4]);
                            $('#sueldo_empleado_act').val(datos[5]);
                            if(datos[6]!=0){
                                $("#con_titulo_act").prop('checked', true);
                            }
                            if(datos[7]!=0){
                                $("#con_cedula_act").prop('checked', true);
                            }
                            
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
                alert("Inserta el id del empleado");
                return false;
            }
        }

        function actualizarDatos() {
            var id_empleado_act = $('#id_empleado_act').val();
            var nombre_act = $('#nombre_act').val();
            var apellidos_act = $('#apellidos_act').val();
            var rfc_correo_act = $('#rfc_correo_act').val();
            var tipo_admin_act = $('#tipo_admin_act').val();
            var con_titulo_act;
            var con_cedula_act;
            var sueldo_empleado_act = $('#sueldo_empleado_act').val();
            var fecha_laborar_act = $('#fecha_laborar_act').val();
            if ($('#con_titulo_act').prop('checked')) {
                con_titulo_act = 'on';
            } else {
                con_titulo_act = 'off';
            }
            if ($('#con_cedula_act').prop('checked')) {
                con_cedula_act = 'on';
            } else {
                con_cedula_act = 'off';
            }
            if (sueldo_empleado_act != '' && fecha_laborar_act != '' && nombre_act != '' && apellidos_act != '' && rfc_correo_act != '' && tipo_admin_act != '' && con_cedula_act != '' && con_titulo_act != '') {
                $.ajax({
                    url: './funciones/actualizarDatosEmpleado.php',
                    type: 'post',
                    data: 'id_empleado_act='+id_empleado_act+'&nombre_act=' + nombre_act + '&apellidos_act=' + apellidos_act + '&rfc_correo_act=' + rfc_correo_act + '&tipo_admin_act=' + tipo_admin_act + '&con_cedula_act=' + con_cedula_act + '&con_titulo_act=' + con_titulo_act + '&sueldo_empleado_act=' + sueldo_empleado_act + '&fecha_laborar_act=' + fecha_laborar_act,
                    success: function(res) {
                        if (res) {
                            alert('Datos Actualizados');
                            limpiarForm();
                            cerrarModal();
                            location.reload();
                        } else {
                            alert('Datos NO actualizados');
                            cerrarModal();
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

        function cerrarModal() {
            $('#modalActualizar').modal('hide');
        }

        function refrescar() {
            $("#myDivTable3").load("./listarClientesInfo.php");
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
                    <h1 class="h2">Panel de administración - Aministración de empleados</h1>
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
                                        <h5>Nuevo empleado</h5>
                                    </label>
                                </div>
                                <div class="col cuadros" style="text-align: center;">
                                    <input type="image" src="./sgv/baja_usuario.svg" width="40%" onclick="ocultarSeccion('#adeudoCliente');">
                                    <label>
                                        <h5>Dar baja empleado</h5>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col cuadros" style="text-align: center;">
                                    <input type="image" src="./sgv/actualizar_cliente.svg" width="40%" onclick="ocultarSeccion('#actualizarCliente');">
                                    <label>
                                        <h5>Actualizar datos empleado</h5>
                                    </label>
                                </div>
                                <div class="col cuadros" style="text-align: center;">
                                    <input type="image" src="./sgv/lista_cliente.svg" width="40%" onclick="ocultarSeccion('#mostrarCliente');">
                                    <label>
                                        <h5>Mostrar empleados</h5>
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
                            <form name="forma01">
                                <div class="row">
                                    <div class="col">
                                        <label for="nombre_agr">Nombres</label>
                                        <input type="text" class="form-control" id="nombre_agr" name="nombre_agr" placeholder="Nombre de empleado">
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="apellidos_agr">Apellidos</label>
                                            <input type="text" class="form-control" id="apellidos_agr" name="apellidos_agr" placeholder="Apellidos empleado">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <br>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="rfc_correo_agr">RFC o Correo</label>
                                            <input type="text" class="form-control" id="rfc_correo_agr" name="rfc_correo_agr" placeholder="RFC o Correo">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="tipo_admin_agr">Puesto de empleado</label>
                                        <select class="form-control" id="tipo_admin_agr" name="tipo_admin_agr">
                                            <option selected>Seleccionar</option>
                                            <option value="1">Administrador</option>
                                            <option value="2">Recepcionista</option>
                                            <option value="3">Terapeuta</option>
                                            <option value="4">Recursos Humanos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="fecha_laborar_agr">Comenzo a laborar el:</label>
                                            <input class="form-control" id="fecha_laborar_agr" name="fecha_laborar_agr" type="date">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="sueldo_empleado_agr">Sueldo:</label>
                                            <input type="number" class="form-control" id="sueldo_empleado_agr" name="sueldo_empleado_agr" placeholder="Sueldo empleado">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check form-switch">
                                            <br>
                                            <br>
                                            <label for="con_titulo_agr">Tiene titulo</label>
                                            <input class="form-check-input" type="checkbox" role="switch" id="con_titulo_agr" name="con_titulo_agr">
                                        </div>
                                        <br>
                                    </div>
                                    <div class="col">
                                        <div class="form-check form-switch">
                                            <br>
                                            <br>
                                            <label for="con_cedula_agr">Tiene cedula</label>
                                            <input class="form-check-input" type="checkbox" role="switch" id="con_cedula_agr" name="con_cedula_agr">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="container">
                                    <div class="row">
                                        <div class="col order-last">
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-outline-success" style="width: 300px;" onclick="if(!agregarDatos()) return false;">Guardar este empleado</button>
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
                                <h3>NUEVO EMPLEADO AGREGADO</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col oculto" id="adeudoCliente">

                        <div class="cuadros-secc rounded-3 border border-3">
                            <form name="forma01">
                                <div class="row">
                                    <div class="col">
                                        <input type="number" class="form-control" id="id_empleado_baja" nombre="id_empleado_baja" placeholder="Id del cliente">
                                    </div>
                                </div>
                                <br>
                                <div class="table-responsive-lg">
                                    <table class="table">
                                        <div class="row">
                                            <div class="col" style="text-align:center;">
                                                <button type="submit" class="btn btn-outline-danger" style="width: 200px;" onclick="if(!asignarBaja()) return false;">Asignar baja</button>
                                            </div>
                                            <div class="col" style="text-align:center;">
                                                <button type="submit" class="btn btn-outline-success" style="width: 200px;" onclick="if(!removerBaja()) return false;">Remover baja</button>
                                            </div>
                                    </table>
                                </div>
                            </form>
                            <!-- tabla -->

                            <!-- fin tabla -->
                        </div>
                        <div class="cuadros-secc rounded-3 border border-3">
                            <div id="divTablaDeudas">
                                <?php include("./listarEmpleados.php"); ?>
                            </div>

                        </div>
                    </div>
                    <div class="col oculto" id="actualizarCliente">
                        <div class="cuadros-secc rounded-3 border border-3">
                            <div class="row">
                                <div class="col">
                                    <input type="number" class="form-control" id="id_empleado_act" name="id_empleado_act" placeholder="Id del empleado">
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
                                        <button type="button" class="btn btn-outline-success" style="width: 300px;" onclick="cargarDatosAct();">Cargar registro de empleado</button>
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
                            <?php include("./listarEmpleadosAct.php"); ?>
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
                                    <div class="col">
                                        <label for="nombre_act">Nombres</label>
                                        <input type="text" class="form-control" id="nombre_act" name="nombre_act" placeholder="Nombre de empleado">
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="apellidos_act">Apellidos</label>
                                            <input type="text" class="form-control" id="apellidos_act" name="apellidos_act" placeholder="Apellidos empleado">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <br>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="rfc_correo_act">RFC o Correo</label>
                                            <input type="text" class="form-control" id="rfc_correo_act" name="rfc_correo_act" placeholder="RFC o Correo">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="tipo_admin_act">Puesto de empleado</label>
                                        <select class="form-control" id="tipo_admin_act" name="tipo_admin_act">
                                            <option selected>Seleccionar</option>
                                            <option value="1">Administrador</option>
                                            <option value="2">Recepcionista</option>
                                            <option value="3">Terapeuta</option>
                                            <option value="4">Recursos Humanos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="fecha_laborar_act">Comenzo a laborar el:</label>
                                            <input class="form-control" id="fecha_laborar_act" name="fecha_laborar_act" type="date">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="sueldo_empleado_act">Sueldo:</label>
                                            <input type="number" class="form-control" id="sueldo_empleado_act" name="sueldo_empleado_act" placeholder="Sueldo empleado">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check form-switch">
                                            <br>
                                            <br>
                                            <label for="con_titulo_act">Tiene titulo</label>
                                            <input class="form-check-input" type="checkbox" role="switch" id="con_titulo_act" name="con_titulo_act">
                                        </div>
                                        <br>
                                    </div>
                                    <div class="col">
                                        <div class="form-check form-switch">
                                            <br>
                                            <br>
                                            <label for="con_cedula_act">Tiene cedula</label>
                                            <input class="form-check-input" type="checkbox" role="switch" id="con_cedula_act" name="con_cedula_act">
                                        </div>
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
                            <?php include("./listarEmpleadosInfo.php"); ?>
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