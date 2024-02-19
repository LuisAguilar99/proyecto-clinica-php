<?php
require "./conecta.php";
$con = conecta();
$date = date('Y-m-d H:i:s');
$id_cliente = $_REQUEST['id_cliente'];
$dia_inicio = $_REQUEST['fecha_inicio'];
$hora_inicio = $_REQUEST['hora_inicio'];
$hora_fin = $_REQUEST['hora_fin'];
$motivo_cita = $_REQUEST['motivo_cita'];
$terapeuta = $_REQUEST['terapeuta'];
$cancelo_cita = $_REQUEST['cancelo_cita'];
$tipo_sesion = $_REQUEST['tipo_sesion'];
// echo 'inicio:'.$dia_inicio;
// echo 'inicio hor:'.$hora_inicio;

$sql = "SELECT * FROM clientes WHERE id_cliente=$id_cliente";
// echo $sql;
$result = $con->query($sql);
$row =  $result->fetch_assoc();
$nombrecliente = $row["nombre"];
$apellidocliente = $row["apellido"];

    if($id_cliente){
  
$sql = "INSERT INTO citas VALUES (NULL,$id_cliente,'$dia_inicio $hora_inicio','$dia_inicio $hora_fin','$nombrecliente $apellidocliente:$motivo_cita','$terapeuta',$tipo_sesion,0)";
$result = $con->query($sql);
// echo $sql;
$sql = "SELECT * FROM citas WHERE fecha_inicio = '$dia_inicio $hora_inicio' AND fecha_fin = '$dia_inicio $hora_fin' AND motivo_cita='$nombrecliente $apellidocliente:$motivo_cita'";
// echo $sql;
$result = $con->query($sql);
$row =  $result->fetch_assoc();
$idCita = $row["id_cita"];
// 
$sql = "INSERT INTO historial VALUES (NULL,$id_cliente,$idCita,1)";
// echo $sql;
$result = $con->query($sql);
// 
$sql = "SELECT * FROM historial WHERE id_cliente = $id_cliente";
$result = $con->query($sql);
if ($result) {
    $acum = 0;
    while ($row = $result->fetch_assoc()) {
        $acum=$acum+1;
    }
    $result->close();
    $con->next_result();
    }
$sql = "UPDATE clientes set no_citas=$acum WHERE id_cliente=$id_cliente";
$result = $con->query($sql);
// actuaexpe
$sql = "INSERT INTO logs VALUES (NULL,1,'NOMBRE USUARIO','El usuario agendo una cita para cliente con id: $id_cliente','$date')";
$result = $con->query($sql);
// actuaexpe

}

$con->close();
header ("Location: ../citas.php");
?>

