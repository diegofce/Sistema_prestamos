<div class="full-box page-header">
    <h3 class="text-left">
        <i class="far fa-calendar-alt fa-fw"></i> &nbsp; RESERVACIONES
    </h3>
    <p class="text-justify">
		Aquí puedes ver y gestionar la lista de reservaciones pendientes.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="reservation-new.html"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PRÉSTAMO</a>
        </li>
        <li>
            <a class="active" href="reservation-reservation.html"><i class="far fa-calendar-alt"></i> &nbsp; RESERVACIONES</a>
        </li>
        <li>
            <a href="reservation-pending.html"><i class="fas fa-solid fa-handshake fa-fw"></i> &nbsp; PRÉSTAMOS</a>
        </li>
        <li>
            <a href="reservation-list.html"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; FINALIZADOS</a>
        </li>
        <li>
            <a href="reservation-search.html"><i class="fas fa-search-dollar fa-fw"></i> &nbsp; BUSCAR POR FECHA</a>
        </li>
    </ul>
</div>

 <div class="container-fluid">
	
	<?php 
		require_once "./controladores/prestamoControlador.php";
		$ins_prestamo = new prestamoControlador();

		echo $ins_prestamo->paginador_prestamos_controlador($pagina[1],15,$_SESSION['privilegio_spm'],$pagina[0],"Reservacion","","");
	?>
</div>