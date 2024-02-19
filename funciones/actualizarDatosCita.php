<?php
require "./conecta.php";
$con = conecta();
// echo $id_cliente;
$id_cita  = $_REQUEST['id_cita'];
$id_cliente = $_REQUEST['id_cliente'];
$dia_inicio = $_REQUEST['fecha_inicio'];
$hora_inicio = $_REQUEST['hora_inicio'];
$hora_fin = $_REQUEST['hora_fin'];
$motivo_cita = $_REQUEST['motivo_cita'];
$terapeuta = $_REQUEST['terapeuta'];
$cancelo_cita = $_REQUEST['cancelo_cita'];
if($cancelo_cita=="on"){
    $cancelo_cita=1;
}else{
    $cancelo_cita=0;
}
if($id_cliente){
$sql = "UPDATE citas SET `id_cliente`='$id_cliente',`fecha_inicio`='$dia_inicio $hora_inicio',`fecha_fin`='$dia_inicio $hora_fin',`motivo_cita`='$motivo_cita',`terapeuta`='$terapeuta',`cancelo_cita`=$cancelo_cita WHERE `id_cita`=$id_cita";
// echo $sql;
$result = $con->query($sql);
// echo $result;
$con->close();
}
echo $sql;
// header ("Location: lista_administradores.php");
header ("Location: ../citas.php");
// header ("Location: ../eliminarCliente.php");
?>
