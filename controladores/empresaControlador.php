<?php
    if($peticionAjax){
        require_once "../modelos/empresaModelo.php";
    }else{
        require_once "./modelos/empresaModelo.php";
    }
    class empresaControlador extends empresaModelo
    {
        //Controlador para obtener los datos de la empresa
        public function datos_empresa_controlador(){
            return empresaModelo::datos_empresa_modelo();
        } // Fin controlador

        //Controlador para agregar empresa
        public function agregar_empresa_controlador(){
            $nombre=mainModel::limpiar_cadena($_POST['empresa_nombre_reg']);
            $email=mainModel::limpiar_cadena($_POST['empresa_email_reg']);
            $telefono=mainModel::limpiar_cadena($_POST['empresa_telefono_reg']);
            $direccion=mainModel::limpiar_cadena($_POST['empresa_direccion_reg']);

            /*--------- Comprobar campos vacios ----------*/
            if($nombre=="" || $email=="" || $telefono=="" || $direccion==""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No has llenado todos los campos que son obligatorios",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            /*--------- Verificar integridad de los datos ----------*/
            if(mainModel::verificar_datos("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}",$nombre)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El NOMBRE no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            if(mainModel::verificar_datos("[0-9()+]{8,20}",$telefono)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrido un error inesperado",
                    "Texto"=>"El TELEFONO no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}",$direccion)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrido un error inesperado",
                    "Texto"=>"La DIRECCIÓN no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrido un error inesperado",
                    "Texto"=>"El CORREO no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            /*--------- Comprobar que no exista la empresa ----------*/
            $check_empresas=mainModel::ejecutar_consulta_simple("SELECT empresa_id FROM empresa");
            if($check_empresas->rowCount()>=1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrido un error inesperado",
                    "Texto"=>"La empresa que intenta registrar ya existe",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            /*--------- Agregar empresa ----------*/
            $datos_empresa_reg=[
                "Nombre"=>$nombre,
                "Email"=>$email,
                "Telefono"=>$telefono,
                "Direccion"=>$direccion
            ];
            $agregar_empresa=empresaModelo::agregar_empresa_modelo($datos_empresa_reg);
            if($agregar_empresa->rowCount()==1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Empresa registrada",
                    "Texto"=>"Los datos de la empresa han sido registrados con éxito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrido un error inesperado",
                    "Texto"=>"No hemos podido registrar la empresa, por favor intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            exit();

        

        }
        // Fin controlador

        // Controlador para actualizar empresa
        public function actualizar_empresa_controlador(){
            $id=mainModel::decryption($_POST['empresa_id_up']);
            $id=mainModel::limpiar_cadena($id);
            $nombre=mainModel::limpiar_cadena($_POST['empresa_nombre_up']);
            $email=mainModel::limpiar_cadena($_POST['empresa_email_up']);
            $telefono=mainModel::limpiar_cadena($_POST['empresa_telefono_up']);
            $direccion=mainModel::limpiar_cadena($_POST['empresa_direccion_up']);

            /*--------- Comprobar campos vacios ----------*/
            if($nombre=="" || $email=="" || $telefono=="" || $direccion==""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrido un error inesperado",
                    "Texto"=>"No has llenado todos los campos que son obligatorios",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            /*--------- Verificar integridad de los datos ----------*/
            if(mainModel::verificar_datos("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}",$nombre)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El NOMBRE no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(mainModel::verificar_datos("[0-9()+]{8,20}",$telefono)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrido un error inesperado",
                    "Texto"=>"El TELEFONO no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}",$direccion)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrido un error inesperado",
                    "Texto"=>"La DIRECCIÓN no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrido un error inesperado",
                    "Texto"=>"El CORREO no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            /* Comprobar privilegios */
            session_start(['name'=>'SPM']);
            if($_SESSION['privilegio_spm']<1 && $_SESSION['privilegio_spm']>2){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrido un error inesperado",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            /*--------- Actualizar empresa ----------*/
            $datos_empresa_up=[
                "ID"=>$id,
                "Nombre"=>$nombre,
                "Email"=>$email,
                "Telefono"=>$telefono,
                "Direccion"=>$direccion
            ];
            if(empresaModelo::actualizar_empresa_modelo($datos_empresa_up)){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Empresa actualizada",
                    "Texto"=>"Los datos de la empresa han sido actualizados con éxito",
                    "Tipo"=>"success"
                ];

            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrido un error inesperado",
                    "Texto"=>"No hemos podido actualizar la empresa, por favor intente nuevamente",
                    "Tipo"=>"error"
                ];

            }
            echo json_encode($alerta);
            exit();
        }

    }