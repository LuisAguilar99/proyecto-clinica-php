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
            -webkit-box-shadow: 0px 10px 13px -7px #000000, 5px 5px 15px 5px rgba(0, 0, 0, 0);
            box-shadow: 0px 10px 13px -7px #000000, 5px 5px 15px 5px rgba(0, 0, 0, 0);
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
            $('#myTable').DataTable({
                "lengthMenu": [
                    [4, 25, 50, -1],
                    [4, 25, 50, "All"]
                ],
                // "paging": false,
                "info": false
            });
        });

        function mostrarInfoEmp() {
            $("#seccionInformacion").removeClass("oculto");
            $("#seccionPermisos").addClass("oculto");
            $("#seccionIncapacidad").addClass("oculto");
            $("#seccionDefault").addClass("oculto");
        }

        function mostrarPermEmp() {
            $("#seccionPermisos").removeClass("oculto");
            $("#seccionInformacion").addClass("oculto");
            $("#seccionIncapacidad").addClass("oculto");
            $("#seccionDefault").addClass("oculto");
        }

        function mostrarIncapEmp() {
            $("#seccionIncapacidad").removeClass("oculto");
            $("#seccionPermisos").addClass("oculto");
            $("#seccionInformacion").addClass("oculto");
            $("#seccionDefault").addClass("oculto");
        }

        function enviar1() {
            var id_empleado = $('#id_empleado_datos').val();
            if (id_empleado != '') {
                $.ajax({
                    url: './funciones/funcionesObtener.php',
                    type: 'post',

                    data: 'id_empleado=' + id_empleado,
                    success: function(res) {
                        if (res != '0') {

                            // separar permisos de datos
                            var datospermisos = res.split("|");
                            // console.log(datospermisos[1]+'\n'); 
                            console.log(datospermisos[2]);
                            // 

                            var datos = res.split("+");
                            $('#nombreEmpleado').val(datos[0]);

                            $('#nombreEmpleadoPermiso').val(datos[0]);
                            $('#nombreEmpleadoIncapacidad').val(datos[0]);
                            

                            $('#nombreEmpleado_p').val(datos[0]);
                            $('#nombreEmpleado_i').val(datos[0]);
                            $('#correoEmpleado').val(datos[1]);
                            $('#sueldoEmpleado').val(datos[2]);
                            $('#laborar_inicio').val(datos[3]);
                            if (datos[4] == '0000-00-00') {
                                $('#laborar_fin').val('Actualmente activo');
                            } else {
                                $('#laborar_fin').val(datos[4]);
                            }

                            switch (datos[5]) {
                                case '1':
                                    $('#puestoEmpleado').text('Administrador');
                                    break;
                                case '2':
                                    $('#puestoEmpleado').text('Recepcionista');
                                    break;
                                case '3':
                                    $('#puestoEmpleado').text('Terapeuta');
                                    break;
                                case '4':
                                    $('#puestoEmpleado').text('Recursos Humanos');
                                    break;
                            }
                            $("#alertInexistente").addClass("oculto");
                            //sacar permisos
                            if (datospermisos[1] != '') {
                                var permisos = datospermisos[1].split("/");
                                var contenido_permisos = '';
                                for (var i = 0; i < permisos.length; i++) {
                                    var dividir = permisos[i].split('+');
                                    contenido_permisos += '<div class="input-group"><span class="input-group-text">Día</span><input type="text" class="form-control datosCargados" value="' + dividir[0] + '" readonly style="background:white;"></div><h6>MOTIVO</h6><input type="text" class="form-control datosCargados" value="' + dividir[1] + '" readonly style="background:white;"><br>';
                                }
                                $("#divPermisos").html(contenido_permisos);
                                //sacarpermisos fin
                            } else {
                                $("#divPermisos").html('<br><h6 style="color:red;">No existen permisos.</h6>');
                            }
                            if (datospermisos[2] != '') {
                                var incapacidad = datospermisos[2].split("/");
                                var contenido_incapacidad = '';
                                for (var i = 0; i < incapacidad.length; i++) {
                                    var dividir = incapacidad[i].split('+');
                                    contenido_incapacidad += '<div class="input-group"><span class="input-group-text">De</span><input type="text" class="form-control datosCargados" value="' + dividir[0] + '" style="background:white;"><span class="input-group-text">a</span><input type="text" class="form-control datosCargados" value="' + dividir[1] + '" style="background:white;"></div><div class="input-group"><span class="input-group-text">Motivo</span><input type="text" class="form-control datosCargados" value="' + dividir[2] + '" style="background:white;"></div><br>';
                                }
                                $("#divIncapacidad").html(contenido_incapacidad);

                            } else {
                                $("#divIncapacidad").html('<br><h6 style="color:red;">No existen incapacidades.</h6>');
                            }
                            $("#botonPermiso").removeClass("oculto");
                            $("#botonIncapacidad").removeClass("oculto");
                        } else {
                            $("#alertInexistente").removeClass("oculto");
                            $('#nombreEmpleado_i').val('');
                            $('#nombreEmpleado_p').val('');
                            $('#nombreEmpleado').val('');
                            $('#correoEmpleado').val('');
                            $('#sueldoEmpleado').val('');
                            $('#laborar_inicio').val('');
                            $('#laborar_fin').val('');
                            $('#puestoEmpleado').text('');
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

        function cerrarModal() {
            $('#modalPermisos').modal('hide');
        }
        function cerrarModalI() {
            $('#modalIncapacidad').modal('hide');
        }
        
        function abrirModal() {
            $('#modalPermisos').modal('show');
        }
        function abrirModalI() {
            $('#modalIncapacidad').modal('show');
        }

        function agregarPermiso() {
            var idEmpleadoPermiso = $('#id_empleado_datos').val();
            var motivoPermiso = $('#motivoPermiso').val();
            var fechaPermiso = $('#fechaPermiso').val();
            if (idEmpleadoPermiso != '' && motivoPermiso != '' && fechaPermiso != '') {
                $.ajax({
                    url: './funciones/agregarPermiso.php',
                    type: 'post',

                    data: 'idEmpleadoPermiso=' + idEmpleadoPermiso + '&motivoPermiso=' + motivoPermiso + '&fechaPermiso=' + fechaPermiso,
                    success: function(res) {
                        if (res != '0') {
                            alert('Permiso añadido al sistema');
                            $('#motivoPermiso').val('');
                            $('#fechaPermiso').val('');
                            cerrarModal();
                            enviar1();
                        } else {
                            alert('El permiso no pudo ser añadido');
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
                alert("Faltan datos por rellenar");
                return false;
            }
        }

        function agregarIncapacidad() {
            var idEmpleadoIncapacidad = $('#id_empleado_datos').val();
            var motivoIncapacidad = $('#motivoIncapacidad').val();
            var fechaInicioIncapacidad = $('#fechaInicioIncapacidad').val();
            var fechaFinIncapacidad = $('#fechaFinIncapacidad').val();
            if (idEmpleadoIncapacidad != '' && motivoIncapacidad != '' && fechaInicioIncapacidad != ''&& fechaFinIncapacidad !='') {
                $.ajax({
                    url: './funciones/agregarIncapacidad.php',
                    type: 'post',

                    data: 'idEmpleadoIncapacidad=' + idEmpleadoIncapacidad + '&motivoIncapacidad=' + motivoIncapacidad + '&fechaInicioIncapacidad=' + fechaInicioIncapacidad+'&fechaFinIncapacidad='+fechaFinIncapacidad,
                    success: function(res) {
                        if (res != '0') {
                            alert('Incapacidad añadida al sistema');
                            $('#motivoIncapacidad').val('');
                            $('#fechaInicioIncapacidad').val('');
                            $('#fechaFinIncapacidad').val('');
                            cerrarModalI();
                            enviar1();
                        } else {
                            alert('La incapacidad no pudo ser añadida');
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
                alert("Faltan datos por rellenar");
                return false;
            }
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
                    <h1 class="h2">Panel de administración - Recursos Humano</h1>
                </div>
            </main>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Modal -->
                <div class="row">
                    <div class="col">
                        <div class="container">
                            <div class="row">
                                <div class="col cuadros" style="text-align: center;">
                                    <input type="image" id="mostrarDatos" name="mostrarDatos" src="./sgv/info_empleado.svg" width="40%" onclick="mostrarInfoEmp();">
                                    <label for="mostrarDatos">
                                        <h5>Información</h5>
                                    </label>
                                </div>
                                <div class="col cuadros" style="text-align: center;">
                                    <input type="image" id="mostrarPermisos" name="mostrarPermisos" src="./sgv/permisos.svg" width="40%" onclick="mostrarPermEmp();">
                                    <label for="mostrarPermisos">
                                        <h5>Permisos</h5>
                                    </label>
                                </div>
                                <div class="col cuadros" style="text-align: center;">
                                    <input type="image" id="mostrarVacaciones" name="mostrarVacaciones" src="./sgv/vacaciones.svg" width="40%" onclick="mostrarIncapEmp();">
                                    <label for="mostrarVacaciones">
                                        <h5>Incapacidades</h5>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="table-responsive cuadros-secc rounded-3"> -->
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">IDE</th>
                                        <th scope="col">NOMBRE DEL EMPLEADO</th>
                                        <th scope="col">DESEMPEÑA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('./funciones/conecta.php');
                                    $con = conecta();
                                    $sql = "SELECT * FROM `empleados`";
                                    // Check for errors
                                    if (mysqli_connect_errno()) {
                                        echo mysqli_connect_error();
                                    }
                                    $result = $con->query($sql);
                                    if ($result) {

                                        while ($row = $result->fetch_assoc()) {
                                    ?>

                                            <tr>
                                                <td><?php echo $row["id_empleado"]; ?></td>
                                                <td><?php echo $row["nombre"] . ' ' . $row["apellido"]; ?></td>
                                                <td><?php
                                                    switch ($row["tipo_puesto"]) {
                                                        case 1:
                                                            echo "Administrador";
                                                            break;
                                                        case 2:
                                                            echo "Recepcionista";
                                                            break;
                                                        case 3:
                                                            echo "Terapeuta";
                                                            break;
                                                        case 4:
                                                            echo "Recursos Humanos";
                                                            break;
                                                    }
                                                    ?></td>
                                            </tr>
                                    <?php
                                        }
                                        $result->close();
                                        $con->next_result();
                                    }
                                    $con->close();
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col" id="seccionDefault">

                        <img src="./LOGO_CU.svg" width="100%" height="100%">
                    </div>

                    <div class="col oculto" id="seccionInformacion">
                        <div class="input-group">
                            <span class="input-group-text">IDE EMPLEADO</span>
                            <input type="number" id="id_empleado_datos" name="id_empleado_datos" class="form-control">
                            <button type="submit" class="btn btn-outline-secondary" onclick="enviar1();">Cargar datos</button>
                        </div>
                        <br>
                        <div class="alert alert-danger oculto" id="alertInexistente" role="alert">
                            El empleado con este IDE <strong>no existe.</strong>
                        </div>
                        <div class="cuadros-secc rounded-3 border border-3">
                            <h4>Datos sobre el empleado</h4>
                            <br>
                            <div class="row">
                                <div class="col-4" style="Word-break: break-all; text-align: center;">
                                    <img src="./user.png" style="width: 100%;" id="fotoEmpleado" name="fotoEmpleado">
                                    <br><br>
                                    <strong id="puestoEmpleado" name="puestoEmpleado"></strong>
                                </div>
                                <div class="col">
                                    <h6>NOMBRE</h6>
                                    <div class="input-group">
                                        <span class="input-group-text" style="background: white;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="25" height="25" viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 511.999 511.999;" xml:space="preserve">
                                                <rect x="174.655" y="73.344" style="fill:#FED159;" width="164.804" height="123.612" />
                                                <rect x="10.426" y="142.965" style="fill:#82DCC7;" width="493.275" height="295.907" />
                                                <circle style="fill:#FFFFFF;" cx="139.956" cy="294.284" r="89.886" />
                                                <circle style="fill:#FCD589;" cx="139.956" cy="280.661" r="32.893" />
                                                <path style="fill:#F64B4A;" d="M186.612,360.219v10.9c-13.597,8.278-29.579,13.048-46.66,13.048s-33.051-4.77-46.648-13.035v-10.913  c0-25.784,20.877-46.66,46.648-46.66C165.723,313.558,186.612,334.435,186.612,360.219z" />
                                                <path d="M502.635,133.493H182.96V82.601h146.078v29.965c0,5.172,4.192,9.365,9.365,9.365c5.173,0,9.365-4.193,9.365-9.365v-39.33  c0-5.172-4.192-9.365-9.365-9.365H173.595c-5.173,0-9.365,4.193-9.365,9.365v60.257H9.365c-5.173,0-9.365,4.193-9.365,9.365v295.905  c0,5.172,4.192,9.365,9.365,9.365h62.564c5.173,0,9.365-4.193,9.365-9.365s-4.192-9.365-9.365-9.365H18.729V152.222h474.542v277.176  h-385.76c-5.173,0-9.365,4.193-9.365,9.365s4.192,9.365,9.365,9.365h395.123c5.173,0,9.365-4.193,9.365-9.365V142.857  C512,137.686,507.807,133.493,502.635,133.493z" />
                                                <path d="M138.889,213.648c16.623,0,32.576,5.021,46.136,14.518c4.24,2.968,10.075,1.937,13.043-2.297  c2.967-4.237,1.938-10.075-2.299-13.043c-16.725-11.714-36.393-17.906-56.882-17.906c-54.728,0-99.252,44.524-99.252,99.252  c0,34.947,17.846,66.667,47.739,84.853c15.495,9.419,33.308,14.399,51.513,14.399c18.223,0,36.042-4.984,51.529-14.413  c29.883-18.181,47.724-49.896,47.724-84.839c0-19.89-5.863-39.081-16.956-55.499c-2.896-4.285-8.717-5.411-13.003-2.517  c-4.285,2.896-5.411,8.717-2.517,13.002c8.994,13.31,13.747,28.875,13.747,45.015c0,22.505-9.131,43.355-25.025,58.38  c-2.349-17.341-12.655-32.182-27.117-40.717c8.519-7.736,13.877-18.895,13.877-31.281c0-23.302-18.958-42.258-42.258-42.258  s-42.258,18.956-42.258,42.258c0,12.387,5.359,23.547,13.878,31.284c-14.463,8.537-24.769,23.379-27.116,40.721  c-15.896-15.027-25.028-35.879-25.028-58.384C58.366,249.771,94.49,213.648,138.889,213.648z M138.889,257.023  c12.974,0,23.529,10.554,23.529,23.529s-10.554,23.529-23.529,23.529s-23.529-10.556-23.529-23.529S125.916,257.023,138.889,257.023  z M138.891,322.813c20.562,0,37.29,16.728,37.29,37.291v5.444c-11.453,5.995-24.24,9.146-37.292,9.146  c-13.042,0-25.829-3.151-37.288-9.142v-5.448C101.6,339.542,118.329,322.813,138.891,322.813z" />
                                                <path d="M446.492,213.65c5.173,0,9.365-4.193,9.365-9.365s-4.192-9.365-9.365-9.365h-39.329c-5.173,0-9.365,4.193-9.365,9.365  s4.192,9.365,9.365,9.365H446.492z" />
                                                <path d="M304.158,213.65h71.79c5.173,0,9.365-4.193,9.365-9.365s-4.192-9.365-9.365-9.365h-71.79c-5.173,0-9.365,4.193-9.365,9.365  S298.985,213.65,304.158,213.65z" />
                                                <path d="M446.492,279.245h-83.027c-5.173,0-9.365,4.193-9.365,9.365s4.192,9.365,9.365,9.365h83.027  c5.173,0,9.365-4.193,9.365-9.365S451.664,279.245,446.492,279.245z" />
                                                <path d="M304.158,297.974h28.091c5.173,0,9.365-4.193,9.365-9.365s-4.192-9.365-9.365-9.365h-28.091  c-5.173,0-9.365,4.193-9.365,9.365S298.985,297.974,304.158,297.974z" />
                                                <path d="M304.158,393.422h142.334c5.173,0,9.365-4.193,9.365-9.365c0-5.172-4.192-9.365-9.365-9.365H304.158  c-5.173,0-9.365,4.193-9.365,9.365C294.794,389.229,298.985,393.422,304.158,393.422z" />
                                                <path d="M304.158,255.811h142.334c5.173,0,9.365-4.193,9.365-9.365s-4.192-9.365-9.365-9.365H304.158  c-5.173,0-9.365,4.193-9.365,9.365S298.985,255.811,304.158,255.811z" />
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                            </svg></span>
                                        <input type="text" id="nombreEmpleado" name="nombreEmpleado" class="form-control datosCargados" readonly style="background:white;">
                                    </div>
                                    <h6>CORREO</h6>
                                    <div class="input-group">
                                        <span class="input-group-text" style="background: white;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="25" height="25" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                <g transform="translate(0 1)">
                                                    <path style="fill:#FFE100;" d="M442.027,442.733H69.973c-19.627,0-35.84-16.213-35.84-35.84V103.107   c0-19.627,16.213-35.84,35.84-35.84h372.053c19.627,0,35.84,16.213,35.84,35.84v303.787   C477.867,426.52,461.653,442.733,442.027,442.733" />
                                                    <path style="fill:#FFFFFF;" d="M34.133,406.893V103.107c0-19.627,16.213-35.84,35.84-35.84h-25.6   c-19.627,0-35.84,16.213-35.84,35.84v303.787c0,19.627,16.213,35.84,35.84,35.84h25.6C50.347,442.733,34.133,426.52,34.133,406.893   " />
                                                    <path style="fill:#FFA800;" d="M467.627,67.267h-25.6c19.627,0,35.84,16.213,35.84,35.84v303.787   c0,19.627-16.213,35.84-35.84,35.84h25.6c19.627,0,35.84-16.213,35.84-35.84V103.107C503.467,83.48,487.253,67.267,467.627,67.267" />
                                                    <path style="fill:#FDCC00;" d="M287.573,268.653l204.8-191.147c-5.973-5.973-15.36-10.24-24.747-10.24H44.373   c-9.387,0-18.773,4.267-24.747,10.24L225.28,268.653C242.347,284.867,269.653,284.867,287.573,268.653" />
                                                    <path d="M467.627,451.267H44.373C19.627,451.267,0,431.64,0,406.893v-194.56c0-5.12,3.413-8.533,8.533-8.533   s8.533,3.413,8.533,8.533v194.56c0,15.36,11.947,27.307,27.307,27.307h423.253c15.36,0,27.307-11.947,27.307-27.307V103.107   c0-15.36-11.947-27.307-27.307-27.307H44.373c-15.36,0-27.307,11.947-27.307,27.307v40.96c0,5.12-3.413,8.533-8.533,8.533   S0,149.187,0,144.067v-40.96C0,78.36,19.627,58.733,44.373,58.733h423.253c24.747,0,44.373,19.627,44.373,44.373v303.787   C512,431.64,492.373,451.267,467.627,451.267z" />
                                                    <path d="M17.067,178.2c0-5.12-3.413-8.533-8.533-8.533S0,173.08,0,178.2c0,5.12,3.413,8.533,8.533,8.533   S17.067,183.32,17.067,178.2" />
                                                    <path d="M256,289.133c-13.653,0-26.453-5.12-37.547-14.507L13.653,83.48c-1.707-1.707-2.56-3.413-2.56-5.973   c0-2.56,0.853-4.267,2.56-5.973c8.533-8.533,18.773-12.8,30.72-12.8h423.253c11.947,0,22.187,4.267,30.72,12.8   c1.707,1.707,2.56,4.267,2.56,5.973c0,2.56-0.853,4.267-2.56,5.973l-204.8,191.147C282.453,284.867,269.653,289.133,256,289.133z    M33.28,78.36L230.4,262.68c14.507,13.653,36.693,13.653,51.2,0l0,0L478.72,78.36c-3.413-1.707-6.827-2.56-11.093-2.56H44.373   C40.107,75.8,36.693,76.653,33.28,78.36z" />
                                                    <g>
                                                        <path style="fill:#FDCC00;" d="M256.853,261.827l-6.827,5.973c-17.92,16.213-2.56,16.213-19.627,0l-6.827-5.973L25.6,433.347    c6.827,5.973,15.36,9.387,24.747,9.387h380.587c9.387,0,17.92-3.413,24.747-9.387L256.853,261.827z" />
                                                        <path style="fill:#FDCC00;" d="M243.2,279.747c-1.707,0-2.56-0.853-4.267-1.707C242.347,283.16,240.64,283.16,243.2,279.747" />
                                                        <path style="fill:#FDCC00;" d="M295.253,263.533l-6.827,5.973c-4.267,3.413-8.533,5.973-12.8,8.533L456.533,434.2    c-6.827,5.973-15.36,9.387-24.747,9.387h36.693c9.387,0,17.92-3.413,24.747-9.387L295.253,263.533z" />
                                                    </g>
                                                    <path d="M467.627,451.267H44.373c-11.093,0-22.187-4.267-30.72-11.947c-1.707-1.707-2.56-4.267-2.56-6.827s0.853-5.12,2.56-5.973   l197.973-170.667c3.413-2.56,8.533-2.56,11.093,0l6.827,5.973c14.507,13.653,36.693,13.653,51.2,0l6.827-5.973   c3.413-2.56,7.68-3.413,11.093,0L496.64,426.52c1.707,1.707,2.56,4.267,2.56,5.973c0,2.56-0.853,5.12-2.56,6.827   C489.813,447,478.72,451.267,467.627,451.267z M34.133,432.493c3.413,0.853,6.827,1.707,10.24,1.707h423.253   c3.413,0,6.827-0.853,10.24-1.707L294.4,273.773l-0.853,0.853c-20.48,19.627-53.76,19.627-74.24,0l-0.853-0.853L34.133,432.493z" />
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                            </svg></span>
                                        <input type="text" id="correoEmpleado" name="correoEmpleado" class="form-control datosCargados" readonly style="background:white;">
                                    </div>
                                    <h6>SUELDO</h6>
                                    <div class="input-group">
                                        <span class="input-group-text" style="background: white;">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 400 400" width="25" height="25" style="enable-background:new 0 0 400 400;" xml:space="preserve">
                                                <g id="XMLID_1378_">
                                                    <path id="XMLID_1384_" style="fill:#FFFFFF;" d="M143.437,130H54.882c-1.19,13.191-11.69,23.691-24.882,24.882v90.236   c13.191,1.19,23.692,11.69,24.882,24.882h88.555C123.043,253.5,110,228.275,110,200S123.043,146.5,143.437,130z" />
                                                    <path id="XMLID_1385_" style="fill:#FFFFFF;" d="M256.563,270h88.555c1.19-13.191,11.69-23.691,24.882-24.882v-90.236   c-13.191-1.19-23.692-11.69-24.882-24.882h-88.555C276.956,146.5,290,171.725,290,200S276.956,253.5,256.563,270z" />
                                                    <path id="XMLID_1386_" style="fill:#6DA544;" d="M200,100v24.5h6.843v16.258c6.973,0.648,13.521,2.201,19.638,4.67   c6.117,2.472,11.429,4.992,15.936,7.564l-11.59,21.897c-0.321-0.429-1.262-1.13-2.817-2.099c-1.556-0.963-3.542-2.008-5.956-3.137   c-2.416-1.123-5.098-2.199-8.049-3.221c-2.953-1.02-5.93-1.738-8.934-2.17v21.892l5.151,1.289   c5.473,1.503,10.408,3.138,14.81,4.908c4.398,1.771,8.129,3.972,11.187,6.602c3.06,2.632,5.419,5.82,7.082,9.578   c1.664,3.756,2.496,8.266,2.496,13.524c0,6.115-1.072,11.32-3.217,15.611c-2.151,4.298-5.021,7.807-8.613,10.546   c-3.597,2.737-7.728,4.807-12.395,6.197c-4.671,1.391-9.579,2.199-14.73,2.413V275.5H200V300h200V100H200z M256.563,130h88.555   c1.19,13.191,11.69,23.691,24.882,24.882v90.236c-13.191,1.19-23.692,11.69-24.882,24.882h-88.555   C276.956,253.5,290,228.275,290,200S276.956,146.5,256.563,130z" />
                                                    <path id="XMLID_1389_" style="fill:#6DA544;" d="M217.467,224.63c0-2.79-1.127-4.964-3.381-6.519   c-2.255-1.558-5.259-2.977-9.014-4.267v19.318C213.334,232.842,217.467,229.995,217.467,224.63z" />
                                                    <path id="XMLID_1390_" style="fill:#91DC5A;" d="M186.235,173.439c0,2.684,0.939,4.801,2.82,6.358   c1.874,1.559,4.691,2.927,8.449,4.106v-19.799C189.991,164.745,186.235,167.859,186.235,173.439z" />
                                                    <path id="XMLID_1391_" style="fill:#91DC5A;" d="M200,275.5h-4.266v-18.836c-7.404-0.643-14.731-2.143-21.974-4.505   c-7.243-2.359-13.765-5.473-19.558-9.34l11.59-23.021c0.429,0.541,1.581,1.427,3.461,2.656c1.875,1.238,4.266,2.522,7.163,3.862   c2.897,1.349,6.171,2.632,9.819,3.869c3.649,1.232,7.407,2.117,11.269,2.655v-21.41l-7.727-2.257   c-5.259-1.61-9.819-3.355-13.682-5.23c-3.865-1.878-7.059-4.052-9.579-6.518c-2.523-2.469-4.403-5.316-5.636-8.533   c-1.233-3.221-1.851-6.979-1.851-11.272c0-5.579,0.965-10.541,2.899-14.891c1.931-4.344,4.531-8.07,7.807-11.188   c3.272-3.111,7.134-5.55,11.591-7.321c4.451-1.77,9.255-2.924,14.407-3.464V124.5H200V100H0v200h200V275.5z M143.437,270H54.882   c-1.19-13.191-11.69-23.691-24.882-24.882v-90.236c13.191-1.19,23.692-11.69,24.882-24.882h88.555   C123.043,146.5,110,171.725,110,200S123.043,253.5,143.437,270z" />
                                                    <path id="XMLID_1394_" style="fill:#FFFFFF;" d="M195.734,140.758c-5.152,0.54-9.956,1.693-14.407,3.464   c-4.456,1.771-8.318,4.21-11.591,7.321c-3.276,3.118-5.876,6.845-7.807,11.188c-1.934,4.35-2.899,9.312-2.899,14.891   c0,4.294,0.618,8.052,1.851,11.272c1.233,3.217,3.114,6.064,5.636,8.533c2.52,2.466,5.713,4.64,9.579,6.518   c3.862,1.874,8.423,3.619,13.682,5.23l7.727,2.257v21.41c-3.862-0.538-7.62-1.423-11.269-2.655   c-3.648-1.237-6.922-2.52-9.819-3.869c-2.897-1.34-5.288-2.624-7.163-3.862c-1.88-1.229-3.033-2.115-3.461-2.656l-11.59,23.021   c5.793,3.867,12.315,6.98,19.558,9.34c7.243,2.362,14.57,3.862,21.974,4.505V275.5H200h6.843v-18.676   c5.151-0.214,10.06-1.022,14.73-2.413c4.667-1.391,8.798-3.46,12.395-6.197c3.592-2.739,6.462-6.248,8.613-10.546   c2.145-4.291,3.217-9.496,3.217-15.611c0-5.259-0.831-9.768-2.496-13.524c-1.663-3.758-4.023-6.946-7.082-9.578   c-3.058-2.63-6.789-4.831-11.187-6.602c-4.402-1.77-9.337-3.405-14.81-4.908l-5.151-1.289v-21.892   c3.003,0.432,5.981,1.15,8.934,2.17c2.951,1.021,5.633,2.098,8.049,3.221c2.415,1.129,4.4,2.174,5.956,3.137   c1.555,0.969,2.496,1.67,2.817,2.099l11.59-21.897c-4.507-2.572-9.819-5.093-15.936-7.564c-6.118-2.469-12.666-4.022-19.638-4.67   V124.5H200h-4.266V140.758z M205.072,213.845c3.755,1.29,6.759,2.709,9.014,4.267c2.254,1.555,3.381,3.729,3.381,6.519   c0,5.365-4.133,8.212-12.395,8.533V213.845z M197.504,183.903c-3.758-1.18-6.575-2.547-8.449-4.106   c-1.881-1.558-2.82-3.675-2.82-6.358c0-5.579,3.756-8.693,11.269-9.334V183.903z" />
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                            </svg></span>
                                        <input type="text" id="sueldoEmpleado" name="sueldoEmpleado" class="form-control datosCargados" readonly style="background:white;">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <h6>FECHA DE LABORACIÓN</h6>
                            <div class="input-group">
                                <span class="input-group-text">De</span>
                                <input type="text" id="laborar_inicio" name="laborar_inicio" class="form-control datosCargados" readonly style="background:white;">
                                <span class="input-group-text">a</span>
                                <input type="text" id="laborar_fin" name="laborar_fin" class="form-control datosCargados" readonly style="background:white;">
                            </div>
                        </div>
                    </div>
                    <div class="col oculto" id="seccionPermisos">
                        <div class="cuadros-secc rounded-3 border border-3">
                            <div class="row">
                                <div class="col-md-7">
                                    <h4>Permisos</h4>
                                </div>
                                <div class="col-md-5 oculto" id="botonPermiso" style="text-align: right;">
                                    <button type="submit" class="btn btn-success" onclick="abrirModal();">Añadir permiso <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"></path>
                                        </svg></button>
                                </div>
                            </div>
                            <br>
                            <h6>NOMBRE</h6>
                            <input type="text" id="nombreEmpleado_p" name="nombreEmpleado_p" class="form-control datosCargados" readonly style="background:white;" readonly>
                            <br>
                            <h6>DÍA DEL PERMISO</h6>
                            <div id="divPermisos">
                                <h6 style="color:red;">Primero carga los datos del empleado.</h6>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="modalPermisos" tabindex="-1" role="dialog" aria-labelledby="modalPermisosLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalPermisosLabel">Añadir permiso</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Permiso para:</label>
                                                    <input type="text" class="form-control" id="nombreEmpleadoPermiso" name="nombreEmpleadoPermiso" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Motivo</label>
                                                    <input type="text" class="form-control" id="motivoPermiso" name="motivoPermiso" placeholder="Motivo del permiso">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Fecha permiso</label>
                                                    <input type="date" class="form-control" id="fechaPermiso" name="fechaPermiso">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" onclick="cerrarModal();">Cancelar</button>
                                        <button type="button" class="btn btn-primary" onclick="agregarPermiso();">Añadir permiso</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col oculto" id="seccionIncapacidad">
                        <div class="cuadros-secc rounded-3 border border-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Incapacidades</h4>
                                </div>
                                <div class="col-md-6 oculto" id="botonIncapacidad" style="text-align: right;">
                                    <button type="submit" class="btn btn-success" onclick="abrirModalI();">Añadir incapacidad <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"></path>
                                        </svg></button>
                                </div>
                            </div>
                            <br>
                            <h6>NOMBRE</h6>
                            <input type="text" id="nombreEmpleado_i" name="nombreEmpleado_i" class="form-control datosCargados" style="background:white;" readonly>
                            <br>
                            <h6>FECHAS DE INCAPACIDAD</h6>
                            <div id="divIncapacidad">
                                <h6 style="color:red;">Primero carga los datos del empleado.</h6>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="modalIncapacidad" tabindex="-1" role="dialog" aria-labelledby="modalIncapacidadLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalIncapacidadLabel">Añadir incapacidad</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Se asignara a:</label>
                                                    <input type="text" class="form-control" id="nombreEmpleadoIncapacidad" name="nombreEmpleadoIncapacidad" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">                                            
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Días de incapacidad</label>
                                                    <div class="input-group"><span class="input-group-text">De</span><input type="date" class="form-control" id="fechaInicioIncapacidad"><span class="input-group-text">a</span><input type="date" class="form-control" id="fechaFinIncapacidad"></div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col">
                                                <div class="form-group">
                                                    <label>Motivo</label>
                                                    <input type="text" class="form-control" id="motivoIncapacidad" name="motivoIncapacidad" placeholder="Motivo de la incapacidad">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" onclick="cerrarModalI();">Cancelar</button>
                                        <button type="button" class="btn btn-primary" onclick="agregarIncapacidad();">Añadir Incapacidad</button>
                                    </div>
                                </div>
                            </div>
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