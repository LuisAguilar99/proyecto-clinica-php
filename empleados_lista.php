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
    <link href="./css/bootstrap.css" rel="stylesheet" crossorigin="anonymous">

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
    </style>
</head>

<body>

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
                    <h1 class="h2">Panel de administración - Lista de empleados</h1>
                </div>
                <!-- <h2></h2> -->
                
            
                <br>
                <!-- mostrar empleados -->
               
                <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                require "./funciones/conecta.php";
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
                        
                        <div class="col">
                            <div class="card">
                                <img src="./user.png" class="card-img-top" height="320" >
                                <div class="card-body">
                                    <h5 class="card-title">Nombre del empleado: <br><?php echo $row["nombre"].' '.$row["apellido"]; ?></h5>
                                    <p class="card-text">El empleado desempeña su puesto como: <?php
                        switch($row["tipo_puesto"]){
                            case 1:
                                echo "Administrador";
                                break;
                                case 2:
                                    echo "Recepcionista";
                                    break;
                                    case 3:
                                        echo "Terapeuta";
                                        break;
                        }                       
                
                        ?><br>
                     El empleado tiene asignado el ID: <?php echo $row["id_empleado"]?>   
                    </p>
                                </div>
                            </div>
                        </div>
                    <?php }
                $result->close();
                $con->next_result();
                 }
                 
$date = date('Y-m-d H:i:s');
$sql = "INSERT INTO logs VALUES (NULL,'$idUsuarioIndex','$usuarioIndex','El usuario consulto lista de empleados','$date')";
$result = $con->query($sql);
                $con->close(); ?>
                </div>





                <!-- /mostrar empleados -->
            </main>
        </div>
    </div>

    <script src="./js/bootstrap.js" crossorigin="anonymous"></script>
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/active.js"></script>
</body>

</html>