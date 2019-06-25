<?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) { ?>

<div class="menu">
    <ul>
        <li class="has-sub"><a href="inicio.php"><i class="fas fa-home"></i> Inicio</a>
        <li class="has-sub"><a href="#"><i class="fas fa-address-book"></i> Registrar</a>
            <ul>
              <?php if ($_SESSION['nivel'] == 1) { ?>
                <li class="has-sub"><a href="registrar_secretario.php">Secretario/a</a>
              <?php } ?>
              <li class="has-sub"><a href="registrar_doctor.php">Doctor</a>
              <li class="has-sub"><a href="registrar_paciente.php">Paciente</a>
              <li class="has-sub"><a href="registrar_insumos.php">Insumos</a></li>
            </ul>
        <li class="has-sub"><a href="#"><i class="fas fa-clipboard-list"></i> Consultar</a>
             <ul>
               <?php if ($_SESSION['nivel'] == 1): ?>
                <li class="has-sub"><a href="auditoria.php">Auditoria</a>
               <?php endif; ?>
                <li class="has-sub"><a href="inventario.php">Inventario</a>
                <li class="has-sub"><a href="trabajadores.php">Trabajadores</a>
                  <ul>
                    <li class="has-sub"><a href="especialidades.php">Especialidades</a>
                  </ul>
                <li class="has-sub"><a href="pacientes.php">Pacientes</a>
            </ul>
        <li class="has-sub"><a href="grafica.php"><i class="fas fa-chart-bar"></i> Graficos</a>
        <li class="has-sub"><a href="#"><i class="fas fa-calendar-check"></i> Citas</a>
             <ul>
                <li class="has-sub"><a href="registrar_citas.php">Registrar</a>
                <li class="has-sub"><a href="citas.php">Consultar</a>
            </ul>
        <li class="has-sub"><a href="configuracion.php"><i class="fas fa-cog"></i> Configuración</a>
        <li class="has-sub"><a href="salir.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
    </ul>
</div>

<?php } ?>

<?php if ($_SESSION['nivel'] == 3): ?>
  <div class="menu">
      <ul>
          <li class="has-sub"><a href="inicio.php"><i class="fas fa-home"></i> Inicio</a>
          <li class="has-sub"><a href="citas.php"><i class="fas fa-calendar-check"></i> Citas</a>
          <li class="has-sub"><a href="configuracion.php"><i class="fas fa-cog"></i> Configuración</a>
          <li class="has-sub"><a href="salir.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
      </ul>
  </div>
<?php endif; ?>
