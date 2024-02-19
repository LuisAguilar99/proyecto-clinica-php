<?php
session_start();
require "./funciones/conecta.php";
if (!$_SESSION['idUsuario']) {
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
    <link href="./css/bootstrap.css" rel="stylesheet" crossorigin="anonymous">

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

    <link href='./css/main_calendario.css' rel='stylesheet' />
    <script src='./js/main_calendario.js'></script>

    <!-- Custom styles for this template -->
    <link href="./css/dashboard.css" rel="stylesheet">
    <script src="./js/bootstrap.js"></script>
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
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'es',
                slotMaxTime: "20:00:00",
                slotMinTime: "10:00:00",
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridDay,listDay'
                },
                initialView: 'listWeek',
                // initialDate: '2020-09-12',
                navLinks: true, // can click day/week names to navigate views
                selectable: true,
                selectMirror: true,

                select: function(arg) {
                    $("#id_modal").modal("show");
                                        
                    $("#fecha_inicio").val(arg.startStr.substr(0,10));
                    
                    calendar.unselect()
                },
                <?php if($_SESSION['tipoAdmin']!=3){
                    echo 'eventClick: function(arg) {';                                       
                    echo 'id_cita = arg.event.id;';                     
                    echo "recibe(id_cita);";                    
                    echo "},";
                }?>
                dayMaxEvents: true,
                // allow "more" link when too many events
                events: [
                    <?php
                    $con = conecta();
                    $sql = "SELECT * FROM `citas`";
                    // Check for errors
                    if (mysqli_connect_errno()) {
                        echo mysqli_connect_error();
                    }
                    $result = $con->query($sql);
                    if ($result) {

                        while ($row = $result->fetch_assoc()) {
                    ?> {
                                id: '<?php echo $row["id_cita"];?>',
                                title: 'Cliente y motivo: <?php echo $row["motivo_cita"] . ' Terapeuta: ' . $row["terapeuta"]; ?>',
                                start: '<?php echo $row["fecha_inicio"]; ?>',
                                end: '<?php echo $row["fecha_fin"]; ?>',
                                backgroundColor: '<?php if($row["cancelo_cita"]){echo "red";}else{echo "green";} ?>'
                            },
                    <?php
                        }
                        $result->close();
                        $con->next_result();
                    }
                    $con->close();
                    ?> {
                        title: 'Creacion del sistema',
                        start: '2021-12-04T04:42:00'
                    }
                ]
            });

            calendar.render();
        });
        function recibe(id_cita) {
            $('#id_cita').val(id_cita);          
            // alert(apellidoCliente);
            if (id_cita != '') {               
                document.formcita.method = 'post';
                document.formcita.action = './citas_2.php';
                document.formcita.submit();
                alert("Datos encontrados");
                return true;
            } else {
                alert("Datos no encontrados");
                return false;
            }

        }
        function reload() {
            window.location = location.href;
        }
        
    </script>
</head>

<body onload="active();">

    <?php include("./navbar/navbar.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <?php include("./navbar/navbar_seccion.php"); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Panel de administración - Administrar citas</h1>
                </div>
                <!-- <h2>Administrar citas</h2> -->
                <div id="calendar" class="demo-calendar fc fc-media-screen fc-direction-ltr fc-theme-standard">
            </main>
        </div>
    </div>
    <!-- INICIO MODAL -->
    <form name="formcita">
        <input type="hidden" name="id_cita" id="id_cita">
    </form>
    <!-- Modal -->
    <div class="modal fade" id="id_modal" tabindex="-1" aria-labelledby="modalAgendarCita" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgendarCita">Agendar cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" onclick="reload();"></button>
                </div>
                <!-- incio form -->
                <form action="./funciones/agregarCitaBase.php" method="post">
                    <div class="modal-body">
                        <!-- id_cliente -->
                        <div class="input-group">
                            <span class="input-group-text">ID Cliente</span>
                            <input type="number" id="id_cliente" name="id_cliente" class="form-control">
                        </div>
                        <br>
                        <!-- //id_cliente -->
                        <!-- fecha -->
                        <div class="input-group">
                            <span class="input-group-text">Día</span>
                            <input type="text" id="fecha_inicio" name="fecha_inicio" class="form-control" maxlength="10">
                        </div>
                        <br>
                        <!-- //fecha -->
                        <!-- fecha -->
                        <div class="input-group">
                            <span class="input-group-text">De</span>
                            <input type="time" id="hora_inicio" name="hora_inicio" class="form-control">
                            <span class="input-group-text">a</span>
                            <input type="time" id="hora_fin" name="hora_fin" class="form-control">
                        </div>
                        <!-- //fecha -->
                        <!-- motivo -->
                        <br>
                        <div class="input-group">
                            <span class="input-group-text">Motivo</span>
                            <input type="text" id="motivo_cita" name="motivo_cita" class="form-control">
                        </div>
                        <!-- //motivo -->
                        <!-- tera -->
                        <br>
                        <div class="input-group">
                            <span class="input-group-text">Terapeuta</span>
                            <input type="text" id="terapeuta" name="terapeuta" class="form-control">
                            <input type="hidden" id="cancelo_cita" name="cancelo_cita" value="0">
                        </div>
                        <!-- //tera -->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="reload();">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Agendar cita</button>
                    </div>
                </form>
                <!-- fin form -->
            </div>
        </div>
    </div>
    <!-- FIN MODAL -->
    <!-- INICIO MODAL -->
    <!-- Modal -->
    <div class="modal fade" id="id_modal2" tabindex="-1" aria-labelledby="modalActualizatCita" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalActualizatCita">Agendar cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" onclick="reload();"></button>
                </div>
                <!-- incio form -->
                <form action="./funciones/agregarCitaBase.php" method="post">
                    <div class="modal-body">
                        <!-- id_cliente -->
                        <div class="input-group">
                            <span class="input-group-text">ID Cliente</span>
                            <input type="number" id="id_cliente" name="id_cliente" class="form-control">
                        </div>
                        <br>
                        <!-- //id_cliente -->
                        <!-- fecha -->
                        <div class="input-group">
                            <span class="input-group-text">Día</span>
                            <input type="text" id="fecha_inicio" name="fecha_inicio" class="form-control">
                        </div>
                        <br>
                        <!-- //fecha -->
                        <!-- fecha -->
                        <div class="input-group">
                            <span class="input-group-text">De</span>
                            <input type="time" id="hora_inicio" name="hora_inicio" class="form-control">
                            <span class="input-group-text">a</span>
                            <input type="time" id="hora_fin" name="hora_fin" class="form-control">
                        </div>
                        <!-- //fecha -->
                        <!-- motivo -->
                        <br>
                        <div class="input-group">
                            <span class="input-group-text">Motivo</span>
                            <input type="text" id="motivo_cita" name="motivo_cita" class="form-control">
                        </div>
                        <!-- //motivo -->
                        <!-- tera -->
                        <br>
                        <div class="input-group">
                            <span class="input-group-text">Terapeuta</span>
                            <input type="text" id="terapeuta" name="terapeuta" class="form-control">

                        </div>
                        <!-- //tera -->
                        <!-- cancelo -->
                        <br>
                        <div class="mb-3 row">
                            <div class="col-sm-10">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="cancelo_cita" name="cancelo_cita" value="0">
                                    <!-- <input class="form-check-input" type="checkbox" role="switch" id="ca">                              -->
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Cita cancelada</label>
                                </div>
                            </div>
                        </div>
                        <!-- //canclo -->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="reload();">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar cita</button>
                    </div>
                </form>
                <!-- fin form -->
            </div>
        </div>
    </div>
    <!-- FIN MODAL -->
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/active.js"></script>
</body>

</html>