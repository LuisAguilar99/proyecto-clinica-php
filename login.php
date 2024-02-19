<?php
session_start();
session_destroy();
?>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">

  <title>Inicio de sesión</title>
  <!-- Bootstrap core CSS -->
  <link href="./css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


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
  <script>
    function recibe1() {
      var usuario = $('#usuario').val();
      var password = $('#password').val();
      // alert(usuario);
      if (usuario != '' && password != '') {
        document.forma11.method = 'post';
        document.forma11.action = './actualizarEmpleado_2.php';
        document.forma11.submit();
        alert("Datos encontrados");
        return true;
      } else {
        alert("Datos no encontrados");
        window.location.reload();
        return false;
      }
    }

    function enviar2() {
      var usuario = $('#usuario').val();
      var password = $('#password').val();
      if (usuario != '' && password != '') {
        $.ajax({
          url: './funciones/VerificarLogin.php',
          type: 'post',
          dataType: 'text',
          data: 'usuario=' + usuario + '&password=' + password,
          success: function(res) {
            if (res == 1) {
              alert('La baja fue asignada');
            } else {

              alert('El usuario no existe');
            }
            // alert(res);
            // alert("Registro actualizado");
            // window.location = location.href;
            return true;
          },
          error: function(res) {
            // alert(res);
            alert('Error al conectar al servidor...');
            return false;
          }
        });
      } else {
        alert("Asegurate de rellenar todos los datos");
        return false;
      }
    }
  </script>
</head>

<body >
<div>
  <div tabindex="-1" role="dialog" id="inicio_sesion">
    <div class="modal-dialog" role="document">
      <div class="modal-content rounded-5" style="background: #D5D8DC">
        <div class="modal-header p-5 pb-4 border-bottom-0">
          <!-- <h5 class="modal-title">Modal title</h5> -->
          <h2 class="fw-bold mb-0">Inicia sesión</h2>
        </div>

        <div class="modal-body p-5 pt-0">
          <form name="forma01" action="./funciones/verificarLogin.php" method="POST">
            <!-- <form name="forma01"> -->
            <div class="form-floating mb-3">
              <input type="text" class="form-control rounded-4" id="usuario" name="usuario" placeholder="Usuario">
              <label for="floatingInput">Usuario</label>
            </div>
            <div class="form-floating mb-3">
              <input type="password" class="form-control rounded-4" id="password" name="password" placeholder="Contraseña">
              <label for="floatingPassword">Contraseña</label>
            </div>
            <button class="w-100 mb-2 btn btn-lg rounded-4 btn btn-outline-dark" type="submit">Entrar</button>
            <small class="text-muted">Para cualquier problema con el inicio de sesión contacta al administrador.</small>

          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
</body>

</html>