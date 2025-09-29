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
                            <th>TIEMPO</th>
                            <th>COSTO</th>
                            <th>SUBTOTAL</th>
                            <th>DETALLE</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center" >
                            <td>Silla plastica</td>
                            <td>7</td>
                            <td>Hora</td>
                            <td>$5.00</td>
                            <td>$35.00</td>
                            <td>
                                <button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="Nombre del item" data-content="Detalle completo del item">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </td>
                            <td><button type="button" class="btn btn-warning"><i class="far fa-trash-alt"></i></button></td>
                        </tr>
                        <tr class="text-center" >
                            <td>Silla metalica</td>
                            <td>9</td>
                            <td>Día</td>
                            <td>$5.00</td>
                            <td>$45.00</td>
                            <td>
                                <button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="Nombre del item" data-content="Detalle completo del item">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </td>
                            <td><button type="button" class="btn btn-warning"><i class="far fa-trash-alt"></i></button></td>
                        </tr>
                        <tr class="text-center" >
                            <td>Mesa plastica</td>
                            <td>5</td>
                            <td>Evento</td>
                            <td>$10.00</td>
                            <td>$50.00</td>
                            <td>
                                <button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="Nombre del item" data-content="Detalle completo del item">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </td>
                            <td><button type="button" class="btn btn-warning"><i class="far fa-trash-alt"></i></button></td>
                        </tr>
                        <tr class="text-center bg-light">
                            <td><strong>TOTAL</strong></td>
                            <td><strong>21 items</strong></td>
                            <td colspan="2"></td>
                            <td><strong>$130.00</strong></td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- formulario -->
        <form action="" autocomplete="off">
            <!-- tus fieldsets de fechas y demás (no los cambio) -->
            ...
        </form>
	</div>
</div>

<!-- MODAL CLIENTE -->
<div class="modal fade" id="ModalCliente" tabindex="-1" role="dialog" aria-labelledby="ModalClienteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalClienteLabel">Agregar cliente</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="input_cliente" class="bmd-label-floating">DNI, Nombre, Apellido, Teléfono</label>
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
        <form class="modal-content FormularioAjax">
            
            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title" id="ModalAgregarItemLabel">
                    Selecciona el formato, cantidad, tiempo y costo
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
                                <label for="detalle_costo_tiempo" class="bmd-label-floating">Costo por unidad de tiempo</label>
                                <input type="text" pattern="[0-9.]{1,15}" class="form-control"
                                       name="detalle_costo_tiempo" id="detalle_costo_tiempo" maxlength="15" required>
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
