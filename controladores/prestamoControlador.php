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
}