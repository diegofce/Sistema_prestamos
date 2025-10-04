<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PRÉSTAMO
    </h3>
    <p class="text-justify">
        Aquí puedes registrar un nuevo préstamo en el sistema. Completa el formulario con la información requerida y guarda los datos.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li><a class="active" href="<?php echo SERVERURL; ?>reservation-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PRÉSTAMO</a></li>
        <li><a href="<?php echo SERVERURL; ?>reservation-reservation/"><i class="far fa-calendar-alt"></i> &nbsp; RESERVACIONES</a></li>
        <li><a href="<?php echo SERVERURL; ?>reservation-pending/"><i class="fas fa-solid fa-handshake fa-fw"></i> &nbsp; PRÉSTAMOS</a></li>
        <li><a href="<?php echo SERVERURL; ?>reservation-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; FINALIZADOS</a></li>
        <li><a href="<?php echo SERVERURL; ?>reservation-search/"><i class="fas fa-search-dollar fa-fw"></i> &nbsp; BUSCAR POR FECHA</a></li>
    </ul>
</div>

<div class="container-fluid">
	<div class="container-fluid form-neon">
        <div class="container-fluid">
            <p class="text-center roboto-medium">AGREGAR USUARIO O ITEMS</p>
            <p class="text-center">
                <?php if(empty($_SESSION['datos_cliente'])){ ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalCliente"><i class="fas fa-user-plus"></i> &nbsp; Agregar Estudiante</button>
                <?php } ?>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalItem"><i class="fas fa-box-open"></i> &nbsp; Agregar item</button>
            </p>
            
            <div>
                <span class="roboto-medium">Estudiante:</span> 
                <?php if(empty($_SESSION['datos_cliente'])){ ?>
                    <span class="text-danger">&nbsp; <i class="fas fa-exclamation-triangle"></i> Seleccione </span>
                <?php }else{ ?>
                    <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/prestamoAjax.php" method="POST" data-form="loans" style="display: inline-block !important;">
                        <input type="hidden" name="id_eliminar_cliente" value="<?php echo $_SESSION['datos_cliente']['ID']; ?>">
                        <?php echo $_SESSION['datos_cliente']['Nombre']." ".$_SESSION['datos_cliente']['Apellido']." (".$_SESSION['datos_cliente']['CC'].")"; ?>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-user-times"></i></button>
                    </form>
                <?php } ?>
            </div>

            <!-- tabla de items -->
            <div class="table-responsive">
                <table class="table table-dark table-sm">
                    <thead>
                        <tr class="text-center roboto-medium">
                            <th>ITEM</th>
                            <th>CANTIDAD</th>
                            <th>FORMATO</th>
                            <th>CANTIDAD DE TIEMPO</th>
                            <th>OBSERVACIÓN</th>
                            <th>DETALLE</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php 
                            if(isset($_SESSION['datos_item']) && count($_SESSION['datos_item'])>=1){
                                $total_items = 0;
                                $total_dias = 0;
                                foreach($_SESSION['datos_item'] as $items){
                                    $total_items += $items['Cantidad'];
                                    $total_dias += $items['Tiempo'];
                        ?>
                        <tr class="text-center">
                            <td><?php echo $items['Nombre']; ?></td>
                            <td><?php echo $items['Cantidad']; ?></td>
                            <td><?php echo $items['Formato']; ?></td>
                            <td><?php echo $items['Tiempo']; ?></td> 
                            <td><?php echo $items['Costo']; ?></td> 
                            <td>
                                <button type="button" class="btn btn-info" 
                                        data-toggle="popover" data-trigger="hover" 
                                        title="Detalle del item" 
                                        data-content="Código: <?php echo $items['Codigo']; ?>">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </td>
                            <td>
                                <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/prestamoAjax.php" method="POST" data-form="loans" autocomplete="off">
                                    <input type="hidden" name="id_eliminar_item" value="<?php echo $items['ID']; ?>">
                                <button type="submit" class="btn btn-warning">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                </form>
                            </td>
                        </tr>
                        <?php 
                                }
                        ?>
                        <tr class="text-center bg-light">
                            <td><strong>TOTAL</strong></td>
                            <td><strong><?php echo $total_items; ?> items</strong><td colspan="5"></td></td>
                        </tr>
                        <?php 
                            }else{
                                $total_dias = 0;
                        ?>
                        <tr class="text-center">
                            <td colspan="7">No hay items agregados</td>
                        </tr>
                        <?php 
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- formulario -->
        <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/prestamoAjax.php" method="POST" data-form="save" autocomplete="off">
            <fieldset>
                <legend><i class="far fa-clock"></i> &nbsp; Fecha y hora de préstamo</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="prestamo_fecha_inicio">Fecha de préstamo</label>
                                <input type="date" class="form-control" name="prestamo_fecha_inicio_reg" value="<?php echo date("Y-m-d"); ?>" id="prestamo_fecha_inicio">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="prestamo_hora_inicio">Hora de préstamo</label>
                                <input type="time" class="form-control" name="prestamo_hora_inicio_reg" value="<?php echo date("H:i"); ?>" id="prestamo_hora_inicio">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend><i class="fas fa-history"></i> &nbsp; Fecha y hora de entrega</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="prestamo_fecha_final">Fecha de entrega</label>
                                <input type="date" class="form-control" name="prestamo_fecha_final_reg" id="prestamo_fecha_final">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="prestamo_hora_final">Hora de entrega</label>
                                <input type="time" class="form-control" name="prestamo_hora_final_reg" id="prestamo_hora_final">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
			<fieldset>
				<legend><i class="fas fa-cubes"></i> &nbsp; Otros datos</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="prestamo_estado" class="bmd-label-floating">Estado</label>
                                <select class="form-control" name="prestamo_estado_reg" id="prestamo_estado">
                                    <option value="" selected="" >Seleccione una opción</option>
                                    <option value="Reservacion">Reservación</option>
                                    <option value="Prestamo">Préstamo</option>
                                    <option value="Finalizado">Finalizado</option>
                                </select>
                            </div>
                        </div>
						<div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="prestamo_total" class="bmd-label-floating">Duración del préstamo</label>
                            <input type="text" class="form-control" readonly
                            value="" name="prestamo_total"
                            id="prestamo_total">

                             </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="prestamo_pagado" class="bmd-label-floating">Total depositado en $</label>
                                <input type="text" pattern="[0-9.]{1,10}" class="form-control" name="prestamo_pagado_reg" id="prestamo_pagado" maxlength="10">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="prestamo_observacion" class="bmd-label-floating">Observación</label>
                                <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}" class="form-control" name="prestamo_observacion_reg" id="prestamo_observacion" maxlength="400">
                            </div>
                        </div>
					</div>
				</div>
			</fieldset>
			<br><br><br>
			<p class="text-center" style="margin-top: 40px;">
				<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
				&nbsp; &nbsp;
				<button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
			</p>
        </form>
	</div>
</div>

<!-- MODAL CLIENTE -->
<div class="modal fade" id="ModalCliente" tabindex="-1" role="dialog" aria-labelledby="ModalClienteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalClienteLabel">Agregar USUARIO</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="input_cliente" class="bmd-label-floating">CC, Nombre, Apellido, Teléfono</label>
                    <input type="text" class="form-control" name="input_cliente" id="input_cliente" maxlength="30">
                </div>
                <div id="tabla_clientes"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="buscar_cliente()"><i class="fas fa-search"></i> Buscar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ITEM -->
<div class="modal fade" id="ModalItem" tabindex="-1" role="dialog" aria-labelledby="ModalItemLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalItemLabel">Agregar item</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="input_item" class="bmd-label-floating">Código, Nombre</label>
                    <input type="text" class="form-control" name="input_item" id="input_item" maxlength="30">
                </div>
                <div id="tabla_items"></div> <!-- 🔥 corregido cierre -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="buscar_item()"><i class="fas fa-search"></i> Buscar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL AGREGAR ITEM -->
<div class="modal fade" id="ModalAgregarItem" tabindex="-1" role="dialog" aria-labelledby="ModalAgregarItemLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content FormularioAjax" action="<?php echo SERVERURL; ?>ajax/prestamoAjax.php" method="POST" data-form="default" autocomplete="off">
            
            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title" id="ModalAgregarItemLabel">
                    Selecciona el formato, cantidad, tiempo y observación.
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <!-- BODY -->
            <div class="modal-body">
                <input type="hidden" name="id_agregar_item" id="id_agregar_item">

                <div class="container-fluid">
                    <div class="row">
                        
                        <!-- Formato -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="detalle_formato" class="bmd-label-floating">Formato de préstamo</label>
                                <select class="form-control" name="detalle_formato" id="detalle_formato">
                                    <option value="Horas" selected>Horas</option>
                                    <option value="Dias">Días</option>
                                    <option value="Evento">Evento</option>
                                    <option value="Mes">Mes</option>
                                </select>
                            </div>
                        </div>

                        <!-- Cantidad -->
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="detalle_cantidad" class="bmd-label-floating">Cantidad de items</label>
                                <input type="number" pattern="[0-9]{1,7}" class="form-control"
                                       name="detalle_cantidad" id="detalle_cantidad" maxlength="7" required>
                            </div>
                        </div>

                        <!-- Tiempo -->
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="detalle_tiempo" class="bmd-label-floating">Tiempo (según formato)</label>
                                <input type="number" pattern="[0-9]{1,7}" class="form-control"
                                       name="detalle_tiempo" id="detalle_tiempo" maxlength="7" required>
                            </div>
                        </div>

                        <!-- Costo -->
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="detalle_costo" class="bmd-label-floating">Observación</label>
                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚ ]{1,15}" class="form-control"
                                       name="detalle_costo" id="detalle_costo" maxlength="15" required>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Agregar</button>
                <button type="button" class="btn btn-secondary" onclick="modal_buscar_item()">Cancelar</button>
            </div>

        </form>
    </div>
</div>


<?php include_once "./vistas/inc/reservation.php"; ?>
