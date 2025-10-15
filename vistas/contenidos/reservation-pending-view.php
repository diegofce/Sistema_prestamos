<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-solid fa-handshake fa-fw"></i> &nbsp; PRÉSTAMOS
    </h3>
    <p class="text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia fugiat est ducimus inventore, repellendus deserunt cum aliquam dignissimos, consequuntur molestiae perferendis quae, impedit doloribus harum necessitatibus magnam voluptatem voluptatum alias!
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>reservation-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PRÉSTAMO</a>
        </li>
        
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>reservation-pending/"><i class="fas fa-solid fa-handshake fa-fw"></i> &nbsp; PRÉSTAMOS</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>reservation-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; FINALIZADOS</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>reservation-search/"><i class="fas fa-search-dollar fa-fw"></i> &nbsp; BUSCAR POR FECHA</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <?php
// Asegurarnos de que $pagina exista y definir valores por defecto
        if (!isset($pagina) || !is_array($pagina)) {
            // Si no se definió en plantilla, intentar obtenerlo desde GET
            $pagina = isset($_GET['views']) ? explode("/", $_GET['views']) : ['reservation-pending'];
        }

        // URL de la vista (ej: "reservation-pending")
        $pagina_url = isset($pagina[0]) ? $pagina[0] : 'reservation-pending';

        // Página actual para la paginación (por defecto 1)
        $pagina_actual = (isset($pagina[1]) && is_numeric($pagina[1]) && (int)$pagina[1] > 0) ? (int)$pagina[1] : 1;
    ?>

	
	<?php 
		require_once "./controladores/prestamoControlador.php";
		$ins_prestamo = new prestamoControlador();

		
        echo $ins_prestamo->paginador_prestamos_controlador($pagina_actual, 15, $_SESSION['privilegio_spm'], $pagina_url, "Prestamo", "", "");


	?>
</div>