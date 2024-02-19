
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="index.php"><?php include("./LOGO_NAV.php"); ?>Consultorio Guadalajara</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

    <input class="form-control form-control-dark w-100" type="text" style="background:#212529" placeholder="¡Hola! Bienvenido/a al sistema de <?php switch($tipoAdminIndex){ case 1:echo "Administración";break;case 2:echo "Recepcepción";break;case 3:echo "Terapeutas";break;}?>" readonly>
      <!-- <h4></h4> -->
    
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="./funciones/cerrar_sesion.php">Cerrar sesión</a>
    </div>
  </div>
</header>