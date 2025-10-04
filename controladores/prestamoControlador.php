<?php
    if($peticionAjax){
        require_once "../modelos/prestamoModelo.php";
    }else{
        require_once "./modelos/prestamoModelo.php";
    }
    class prestamoControlador extends prestamoModelo{
        /*--------- Controlador buscar cliente prestamo ----------*/
        public function buscar_cliente_prestamo_controlador(){
            $cliente=mainModel::limpiar_cadena($_POST['buscar_cliente']);

            // Comprobar texto
            if($cliente==""){
                return '<div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                        Debe ingresar CC, Nombre, Apellido o Teléfono de un cliente
                    </p>
                </div>';
                exit();

            }
            /*Seleccionando clientes en la base de datos*/
            
            
        /*--------- Fin controlador buscar cliente prestamo ----------*/
        $datos_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_dni LIKE '%$cliente%' OR cliente_nombre LIKE '%$cliente%' OR cliente_apellido LIKE '%$cliente%' OR cliente_telefono LIKE '%$cliente%' ORDER BY cliente_nombre ASC");
        
        if($datos_cliente->rowCount()>=1){
            $datos_cliente=$datos_cliente->fetchAll();
            $tabla='<div class="table-responsive"><table class="table table-hover table-bordered table-sm"><tbody>';
            foreach($datos_cliente as $rows){
                $tabla.='<tr class="text-center">
                                    <td>'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].' - '.$rows['cliente_dni'].'</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" onclick="agregar_cliente('.$rows['cliente_id'].')"><i class="fas fa-user-plus"></i></button>
                                    </td>
                                </tr>';
            }
            $tabla.='</tbody></table></div>';
            return $tabla;

        }else{
            return '<div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                        No hemos encontrado ningún usuario en el sistema que coincida con <strong>“'.$cliente.'”</strong>
                    </p>
                </div>';
                exit();

        }
    }

    /*--------- Controlador agregar cliente prestamo ----------*/
    public function agregar_cliente_prestamo_controlador(){
        $id=mainModel::limpiar_cadena($_POST['id_agregar_cliente']);
        
        $check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='$id'");
        if($check_cliente->rowCount()<=0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No se encontro usuario en el sistema",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $campos=$check_cliente->fetch();

            /* Iniciando la sesion */
            session_start(['name'=>'SPM']);
            
            if(empty($_SESSION['datos_cliente'])) {
               $_SESSION['datos_cliente']=[
                    "ID"=>$campos['cliente_id'],
                    "CC"=>$campos['cliente_dni'],
                    "Nombre"=>$campos['cliente_nombre'],
                    "Apellido"=>$campos['cliente_apellido'],
                ];
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Usuario agregado",
                    "Texto"=>"El usuario se agrego al prestamo",
                    "Tipo"=>"success"
               ];
               echo json_encode($alerta);

            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido agregar usuario al prestamo",
                    "Tipo"=>"error"
                ];

            }

        }
    } // Fin controlador

    /*--------- Controlador eliminar cliente prestamo ----------*/
    public function eliminar_cliente_prestamo_controlador(){
        /* Iniciando la sesion */
        session_start(['name'=>'SPM']);

        unset($_SESSION['datos_cliente']);

        if(empty($_SESSION['datos_cliente'])) {
            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Usuario eliminado",
                "Texto"=>"El usuario se elimino del prestamo",
                "Tipo"=>"success"
           ]; 
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido eliminar usuario del prestamo",
                "Tipo"=>"error"
            ];

        }
        echo json_encode($alerta);
    } // Fin controlador

    /*--------- Controlador buscar item prestamo ----------*/
    public function buscar_item_prestamo_controlador(){
        $item=mainModel::limpiar_cadena($_POST['buscar_item']);

            // Comprobar texto
            if($item==""){
                return '<div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                        Debe ingresar Codigo o Nombre, del item
                    </p>
                </div>';
                exit();

            }
            /*Seleccionando clientes en la base de datos*/
            
        $datos_item=mainModel::ejecutar_consulta_simple("SELECT * FROM item WHERE (item_codigo LIKE '%$item%' OR item_nombre LIKE '%$item%') AND (item_estado='Habilitado') ORDER BY item_nombre ASC");
        
        if($datos_item->rowCount()>=1){
            $datos_item=$datos_item->fetchAll();
            $tabla='<div class="table-responsive"><table class="table table-hover table-bordered table-sm"><tbody>';
            foreach($datos_item as $rows){
                $tabla.='<tr class="text-center">
                                    <td>'.$rows['item_codigo'].' - '.$rows['item_nombre'].'</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" onclick="modal_agregar_item('.$rows['item_id'].')"><i class="fas fa-box-open"></i></button>
                                    </td>
                                </tr>';
            }
            $tabla.='</tbody></table></div>';
            return $tabla;

        }else{
            return '<div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                        No hemos encontrado ningún item en el sistema que coincida con <strong>“'.$item.'”</strong>
                    </p>
                </div>';
                exit();

        }
    }/*--------- Fin controlador ----------*/
    /*--------- Controlador agregar item prestamo ----------*/
    public function agregar_item_prestamo_controlador(){
        // Se obtiene el id del item
        $id=mainModel::limpiar_cadena($_POST['id_agregar_item']);
        /* Se comprueba en la base de datos */
        $check_item=mainModel::ejecutar_consulta_simple("SELECT * FROM item WHERE item_id='$id' AND item_estado='Habilitado'");
        if($check_item->rowCount()<=0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No se encontro item en el sistema",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $campos=$check_item->fetch();
        }
        /* Recuperando detalles del prestamo*/
        $formato=mainModel::limpiar_cadena($_POST['detalle_formato']);
        $cantidad=mainModel::limpiar_cadena($_POST['detalle_cantidad']);
        $tiempo=mainModel::limpiar_cadena($_POST['detalle_tiempo']);
        $costo=mainModel::limpiar_cadena($_POST['detalle_costo']);

        if($cantidad=="" || $tiempo=="" || $costo==""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No has llenado todos los campos que son obligatorios",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        /* Verificando integridad de los datos */
        if(mainModel::verificar_datos("[0-9]{1,5}",$cantidad)){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"La cantidad no coincide con el formato solicitado",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        if(mainModel::verificar_datos("[0-9]{1,5}",$tiempo)){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"El tiempo no coincide con el formato solicitado",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚ ]{1,15}",$costo)){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"El costo no coincide con el formato solicitado",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        if($formato!="Horas" && $formato!="Dias" && $formato!="Evento" && $formato!="Mes"){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"El formato no es valido",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        
        session_start(['name'=>'SPM']);

        if(empty($_SESSION['datos_item'][$id])) {

              $_SESSION['datos_item'][$id]=[
                 "ID"=>$campos['item_id'],
                 "Codigo"=>$campos['item_codigo'],
                 "Nombre"=>$campos['item_nombre'],
                 "Formato"=>$formato,
                 "Cantidad"=>$cantidad,
                 "Tiempo"=>$tiempo,
                 "Costo"=>$costo
                ];
                $alerta=[
                 "Alerta"=>"recargar",
                 "Titulo"=>"Item agregado",
                 "Texto"=>"El item se agrego al prestamo",
                 "Tipo"=>"success"
              ];
              echo json_encode($alerta);

        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"El item ya se encuentra agregado en el prestamo",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();

        }
    } // Fin controlador

    /*--------- Controlador eliminar item prestamo ----------*/
    public function eliminar_item_prestamo_controlador(){
        // Se obtiene el id del item
        $id=mainModel::limpiar_cadena($_POST['id_eliminar_item']);
        /* iniciando la sesion */
        session_start(['name'=>'SPM']);

        unset($_SESSION['datos_item'][$id]);
        if(empty($_SESSION['datos_item'][$id])) {
            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Item eliminado",
                "Texto"=>"El item se elimino del prestamo",
                "Tipo"=>"success"
           ];
           
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido eliminar el item del prestamo",
                "Tipo"=>"error"
            ];
        }
        echo json_encode($alerta);
            exit();
    } // Fin controlador

    /*--------- Controlador calcular duración prestamo ----------*/
    public function carcular_duracion_prestamo_controlador(){
        $fecha_inicio = $_POST['prestamo_fecha_inicio_reg'] . " " . $_POST['prestamo_hora_inicio_reg'];
        $fecha_fin    = $_POST['prestamo_fecha_final_reg'] . " " . $_POST['prestamo_hora_final_reg'];

        $inicio = new DateTime($fecha_inicio);
        $fin    = new DateTime($fecha_fin);
        $diff   = $inicio->diff($fin);

        if($diff->d > 0){
            $duracion = $diff->d . " días";
        } elseif($diff->h > 0){
            $duracion = $diff->h . " horas";
        } else {
            $duracion = $diff->i . " minutos";
        }

        return $duracion;
    }
    /*--------- Fin controlador ----------*/


    /*--------- Controlador datos prestamo  ----------*/

    public function datos_prestamo_controlador($tipo,$id){
        $tipo=mainModel::limpiar_cadena($tipo);
        $id=mainModel::decryption($id);
        $id=mainModel::limpiar_cadena($id);
        return prestamoModelo::datos_prestamo_modelo($tipo,$id);
    } // Fin controlador

    /*--------- Controlador agregar prestamo ----------*/

    public function agregar_prestamo_controlador(){

        // iniciamos la sesion
        session_start(['name'=>'SPM']);

        
        // verificar items
        if(!isset($_SESSION['datos_item']) || count($_SESSION['datos_item']) === 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No has agregado ningun item al prestamo",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        // verificar cliente
        if(empty($_SESSION['datos_cliente'])){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No has agregado ningun cliente al prestamo",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        /* Recibiendo datos del formulario */
        $fecha_inicio=mainModel::limpiar_cadena($_POST['prestamo_fecha_inicio_reg']);
        $hora_inicio=mainModel::limpiar_cadena($_POST['prestamo_hora_inicio_reg']);
        $fecha_final=mainModel::limpiar_cadena($_POST['prestamo_fecha_final_reg']);
        $hora_final=mainModel::limpiar_cadena($_POST['prestamo_hora_final_reg']);
        $estado=mainModel::limpiar_cadena($_POST['prestamo_estado_reg']);
        $total_pagado=mainModel::limpiar_cadena($_POST['prestamo_pagado_reg']);
        $observacion=mainModel::limpiar_cadena($_POST['prestamo_observacion_reg']);
        
        /* Comprobando integridad de los datos */
        if(mainModel::verificar_fecha($fecha_inicio)){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"La fecha de inicio no coincide con el formato solicitado",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if(mainModel::verificar_datos("([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])",$hora_inicio)){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"La hora de inicio no coincide con el formato solicitado",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if(mainModel::verificar_fecha($fecha_final)){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"La fecha final no coincide con el formato solicitado",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if(mainModel::verificar_datos("([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])",$hora_final)){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"La hora final no coincide con el formato solicitado",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        if(mainModel::verificar_datos("^[0-9]+(\.[0-9]{1,2})?$",$total_pagado)){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"El total depositado no coincide con el formato solicitado",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        if($observacion!=""){
            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}",$observacion)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"La observacion no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }
        if($estado!="Reservacion" && $estado!="Prestamo" && $estado!="Finalizado"){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"El estado del prestamo no es valido",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
    /* comprobar fechas */
        if(strtotime($fecha_final) < strtotime($fecha_inicio)){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"la fecha de entrega no puede ser menor a la fecha de inicio",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        /* formateando fechas y horas */
        $total_prestamo = 0;
        foreach($_SESSION['datos_item'] as $item){
            $cantidad = (float)$item['Cantidad']; 
            $costo    = (float)$item['Costo']; 
            $tiempo   = (float)preg_replace('/[^0-9.]/', '', $item['Tiempo']);  

            $subtotal = $cantidad * $costo * $tiempo;
            $total_prestamo += $subtotal;
        }

        $total_prestamo = number_format($total_prestamo,2,'.','');;

        $total_pagado=number_format($total_pagado,2,'.','');

        $fecha_inicio=date("Y-m-d", strtotime($fecha_inicio));

        $fecha_final=date("Y-m-d", strtotime($fecha_final));

        $hora_inicio=date("H:i a", strtotime($hora_inicio));

        $hora_final=date("H:i a", strtotime($hora_final));

        /* Generar codigo de prestamo */
        $correlativo=mainModel::ejecutar_consulta_simple("SELECT prestamo_id FROM prestamo");
        $correlativo=($correlativo->rowCount())+1;
        $codigo=mainModel::generar_codigo_aleatorio("CP",7,$correlativo);

        $datos_prestamo_reg=[
            "Codigo"=>$codigo,
            "FechaInicio"=>$fecha_inicio,
            "HoraInicio"=>$hora_inicio,
            "FechaFinal"=>$fecha_final,
            "HoraFinal"=>$hora_final,
            "Cantidad"=>count($_SESSION['datos_item']),
            "Total"=>$total_prestamo,
            "Pagado"=>$total_pagado,
            "Estado"=>$estado,
            "Observacion"=>$observacion,
            "Usuario"=>$_SESSION['id_spm'],
            "Cliente"=>$_SESSION['datos_cliente']['ID']
        ];

        /* Guardar datos */
        $agregar_prestamo=prestamoModelo::agregar_prestamo_modelo($datos_prestamo_reg);

        /* Comprobar si se guardaron */
        if($agregar_prestamo->rowCount()!=1){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido registrar el prestamo, por favor intente nuevamente",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        /* agregar pago*/
        if($total_pagado>0){
            $datos_pago_reg=[
                "Total"=>$total_pagado,
                "Fecha"=>$fecha_inicio,
                "Codigo"=>$codigo,
            ];
            $agregar_pago=prestamoModelo::agregar_pago_modelo($datos_pago_reg);
            if($agregar_pago->rowCount()!=1){
                prestamoModelo::eliminar_prestamo_modelo($codigo,"Prestamo");
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido registrar el pago del prestamo, por favor intente nuevamente",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            /* agregar detalle de prestamo */
            $errores_detalle=0;
            foreach($_SESSION['datos_item'] as $items){
                $costo=number_format($items['Costo'],2,'.','');
                $descripcion=$items['Codigo']." ".$items['Nombre'];

                $datos_detalle_reg=[
                    "Cantidad"=>$items['Cantidad'],
                    "Formato"=>$items['Formato'],
                    "Tiempo"=>$items['Tiempo'],
                    "Costo"=>$costo,
                    "Descripcion"=>$descripcion,
                    "Prestamo"=>$codigo,
                    "Item"=>$items['ID']
                ];
                $agregar_detalle=prestamoModelo::agregar_detalle_modelo($datos_detalle_reg);

                if($agregar_detalle->rowCount()!=1){
                    $errores_detalle=1;
                    break;
            
                }
            }
            if($errores_detalle==0){
                    unset($_SESSION['datos_cliente']);
                    unset($_SESSION['datos_item']);

                    $alerta=[
                        "Alerta"=>"recargar",
                        "Titulo"=>"Prestamo registrado",
                        "Texto"=>"Los datos del prestamo se registraron con exito",
                        "Tipo"=>"success"
                    ];
                }else{
                    prestamoModelo::eliminar_prestamo_modelo($codigo,"Detalle");
                    prestamoModelo::eliminar_prestamo_modelo($codigo,"Pago");
                    prestamoModelo::eliminar_prestamo_modelo($codigo,"Prestamo");
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"No hemos podido registrar los detalles del prestamo, por favor intente nuevamente (Error: 003)",
                        "Tipo"=>"error"
                    ];
                }

                echo json_encode($alerta);

            } else {
                /* agregar detalle de prestamo aunque no haya pago */
                $errores_detalle = 0;
                foreach($_SESSION['datos_item'] as $items){
                    $costo = is_numeric($items['Costo']) ? number_format((float)$items['Costo'],2,'.','') : 0.00;
                    $descripcion=$items['Codigo']." ".$items['Nombre'];

                    $datos_detalle_reg=[
                        "Cantidad"=>$items['Cantidad'],
                        "Formato"=>$items['Formato'],
                        "Tiempo"=>$items['Tiempo'],
                        "Costo"=>$costo,
                        "Descripcion"=>$descripcion,
                        "Prestamo"=>$codigo,
                        "Item"=>$items['ID']
                    ];
                    $agregar_detalle=prestamoModelo::agregar_detalle_modelo($datos_detalle_reg);

                    if($agregar_detalle->rowCount()!=1){
                        $errores_detalle=1;
                        break;
                    }
                }

                if($errores_detalle==0){
                    unset($_SESSION['datos_cliente']);
                    unset($_SESSION['datos_item']);

                    $alerta=[
                        "Alerta"=>"recargar",
                        "Titulo"=>"Préstamo registrado",
                        "Texto"=>"Los datos del préstamo se registraron con éxito",
                        "Tipo"=>"success"
                    ];
                } else {
                    prestamoModelo::eliminar_prestamo_modelo($codigo,"Detalle");
                    prestamoModelo::eliminar_prestamo_modelo($codigo,"Prestamo");
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"No hemos podido registrar los detalles del préstamo, por favor intente nuevamente (Error: 004)",
                        "Tipo"=>"error"
                    ];
                }

                echo json_encode($alerta);
            }

    } // Fin controlador  
    
    /* controlador paginara prestamos */
    public function paginador_prestamos_controlador($pagina,$registros,$privilegios,$url,$tipo,$fecha_inicio,$fecha_final){

        $pagina=mainModel::limpiar_cadena($pagina);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegios=mainModel::limpiar_cadena($privilegios);

        $url=mainModel::limpiar_cadena($url);
        $url=SERVER.$url."/";

        $tipo=mainModel::limpiar_cadena($tipo);

        $fecha_inicio=mainModel::limpiar_cadena($fecha_inicio);

        $fecha_final=mainModel::limpiar_cadena($fecha_final);
        
        
        $tabla="";

        $pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1 ;
        $inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0 ;

        if($tipo=="Busqueda"){
            if(mainModel::verificar_fecha($fecha_inicio) || mainModel::verificar_fecha($fecha_final)){
                return '<div class="alert alert-danger text-center">
                    <p><i class="fas fa-exclamation-triangle fa-2x"></i></p>
                    <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
                    <p class="mb-0">Lo sentimos, no podemos realizar la búsqueda ya que una de las fechas que ha ingresado no es válida.</p>
                </div>';
                exit();

            }

        }

        $campos="prestamo.prestamo_id, prestamo.prestamo_codigo, prestamo.prestamo_fecha_inicio, prestamo.prestamo_fecha_final, prestamo.prestamo_total, prestamo.prestamo_pagado, prestamo.prestamo_estado, prestamo.usuario_id, prestamo.cliente_id, cliente.cliente_nombre, cliente.cliente_apellido";

        if($tipo=="Busqueda" && $fecha_inicio!="" && $fecha_final!=""){
            $consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM prestamo INNER JOIN cliente ON prestamo.cliente_id=cliente.cliente_id WHERE (prestamo.prestamo_fecha_inicio BETWEEN '$fecha_inicio' AND '$fecha_final') ORDER BY prestamo.prestamo_fecha_inicio DESC LIMIT $inicio,$registros";

        }else{
            $consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM prestamo INNER JOIN cliente ON prestamo.cliente_id=cliente.cliente_id WHERE prestamo.prestamo_estado='$tipo' ORDER BY prestamo.prestamo_fecha_inicio DESC LIMIT $inicio,$registros";
        }
        $conexion=mainModel::conectar();
        $datos=$conexion->query($consulta);
        $datos=$datos->fetchAll();

        $total=$conexion->query("SELECT FOUND_ROWS()");
        $total=$total->fetchColumn();

        $Npaginas=ceil($total/$registros);

        $tabla.='
            <div class="table-responsive">
                <table class="table table-dark table-sm">
                    <thead>
                        <tr class="text-center roboto-medium">
                            <th>#</th>
                            <th>CLIENTE</th>
                            <th>FECHA PRESTAMO</th>
                            <th>FECHA ENTREGA</th>
                            <th>TIPO</th>
                            <th>ESTADO</th>
                            <th>DOCS</th>';
                            if($privilegios==1 || $privilegios==2){
                                $tabla.='<th>ACTUALIZAR</th>';
                            }
                            if($privilegios==1){
                                $tabla.='<th>ELIMINAR</th>';
                            }
                        $tabla.='</tr>
                    </thead>
                    <tbody>';
                    if($total>=1 && $pagina<=$Npaginas){
                        $contador=$inicio+1;
                        foreach($datos as $rows){
                            $tabla.='
                                <tr class="text-center" >
                                    <td>'.$contador.'</td>
                                    <td>'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].'</td>
                                    <td>'.date("d-m-Y", strtotime($rows['prestamo_fecha_inicio'])).'</td>
                                    <td>'.date("d-m-Y", strtotime($rows['prestamo_fecha_final'])).'</td>
                                    <td>'.$rows['prestamo_estado'].'</td>';
                                    if($rows['prestamo_pagado']<$rows['prestamo_total']){
                                        $tabla.='<td>Pendiente: <span class="badge badge-danger">'.MODENA.number_format(($rows['prestamo_total']-$rows['prestamo_pagado']),2,'.',',').'</span></td>';

                                    }else{
                                        $tabla.='<td><span class="badge badge-light">Cancelado</span></td>';
                                    }
                                    $tabla.='
                                        <td>
                                            <a href="'.SERVER.'facturas/invoice.php?id='.mainModel::encryption($rows['prestamo_id']).'" class="btn btn-info" target="_blank"><i class="fas fa-file-pdf"></i>
                                            </a>
                                        </td>
                                    ';
                                    if($privilegios==1 || $privilegios==2){

                                        if($rows['prestamo_estado']=="Finalizado" && $rows['prestamo_pagado']==$rows['prestamo_total']){
                                            $tabla.='<td>
                                            <button  class="btn btn-success" disabled>
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </td>';

                                        }else{
                                            $tabla.='<td>
                                            <a href="'.SERVER.'reservation-update/'.mainModel::encryption($rows['prestamo_id']).'/" class="btn btn-success">
                                                <i class="fas fa-sync-alt"></i>
                                            </a>
                                        </td>';

                                        }
                                        
                                    }
                                    if($privilegios==1){
                                        $tabla.='
                                        <td>
                                            <form class="FormularioAjax" action="'.SERVER.'ajax/prestamoAjax.php" method="POST" data-form="delete" autocomplete="off">
                                                <input type="hidden" name="prestamo_codigo_del" value="'.mainModel::encryption($rows['prestamo_codigo']).'">
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>';
                                    }
                                    
                            $tabla.='</tr>';
                            $contador++;
                        }
                        $reg_final=$contador-1;

                    }else{
                        if($total>=1){
                            $tabla.='
                                <tr class="text-center" >
                                    <td colspan="9">
                                        <a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haga clic aquí para recargar el listado</a>
                                    </td>
                                </tr>
                            ';
                        }else{
                            $tabla.='
                                <tr class="text-center" >
                                    <td colspan="9">No hay registros en el sistema</td>
                                </tr>
                            ';
                            
                        }

                    }
                    $tabla.='
                    </tbody></table></div>';

                    if($total>=1 && $pagina<=$Npaginas){
                        $reg_inicio = $inicio + 0;
                        $tabla.='<p class="text-right">Mostrando prestamos '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';

                        $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
                    }
                    return $tabla;

    }
}