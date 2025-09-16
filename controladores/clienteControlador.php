<?php

    if($peticionAjax){
        require_once "../modelos/clienteModelo.php";
    }else{
        require_once "./modelos/clienteModelo.php";
    }
//agregar cliente controlador
    class clienteControlador extends clienteModelo{
        public function agregar_cliente_controlador(){
            $dni = mainModel::limpiar_cadena($_POST['cliente_dni_reg']);
            $nombre = mainModel::limpiar_cadena($_POST['cliente_nombre_reg']);
            $apellido = mainModel::limpiar_cadena($_POST['cliente_apellido_reg']);
            $telefono = mainModel::limpiar_cadena($_POST['cliente_telefono_reg']);
            $direccion = mainModel::limpiar_cadena($_POST['cliente_direccion_reg']);
            $ficha = mainModel::limpiar_cadena($_POST['cliente_ficha_reg']);
            $programa = mainModel::limpiar_cadena($_POST['cliente_programa_reg']);

            //verificar campos vacios 
            if($dni=="" || $nombre=="" || $apellido=="" || $telefono=="" || $direccion==""){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No has llenado todos los campos que son obligatorios",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            //verificar integridad de los datos
            if(mainModel::verificar_datos("[0-9-]{1,27}",$dni)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El # de CC no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}",$nombre)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El nombre no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}",$apellido)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrido un error inesperado",
                    "Texto"=>"El apellido no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(mainModel::verificar_datos("[0-9()+]{8,20}",$telefono)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrido un error inesperado",
                    "Texto"=>"El telefono no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(mainModel::verificar_datos("[a-zA-Z0-9 ]{1,100}",$direccion)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrido un error inesperado",
                    "Texto"=>"La direccion no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if($ficha!=""){
                if(mainModel::verificar_datos("[0-9-]{1,20}",$ficha)){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrido un error inesperado",
                        "Texto"=>"La ficha no coincide con el formato solicitado",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }
            if($programa!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,100}",$programa)){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrido un error inesperado",
                        "Texto"=>"El programa académico no coincide con el formato solicitado",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }
            //Comprobar DNI
            $check_dni = mainModel::ejecutar_consulta_simple("SELECT cliente_dni FROM cliente WHERE cliente_dni='$dni'");
            if($check_dni->rowCount()>0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El # de CC ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            $datos_cliente_reg = [
                "DNI"=>$dni,
                "NOMBRE"=>$nombre,
                "APELLIDO"=>$apellido,
                "TELEFONO"=>$telefono,
                "DIRECCION"=>$direccion
                ,"FICHA"=>$ficha,
                "PROGRAMA"=>$programa
            ];
            $agregar_cliente = clienteModelo::agregar_cliente_modelo($datos_cliente_reg);
            if($agregar_cliente->rowCount()==1){
                $alerta = [
                    "Alerta"=>"limpiar",
                    "Titulo"=>"Cliente registrado",
                    "Texto"=>"Los datos del cliente se registraron con éxito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No se pudo registrar el cliente, por favor intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            exit();
        }

        		/*--------- Controlador paginar cliente ---------*/
		public function paginador_cliente_controlador($pagina,$registros,$privilegio,$url,$busqueda){

			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			$privilegio=mainModel::limpiar_cadena($privilegio);

			$url=mainModel::limpiar_cadena($url);
			$url=SERVERURL.$url."/";

			$busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";

			$pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1 ;
			$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0 ;

			if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente WHERE (cliente_dni LIKE '%$busqueda%' OR cliente_nombre LIKE '%$busqueda%' OR cliente_apellido LIKE '%$busqueda%' OR cliente_telefono LIKE '%$busqueda%') ORDER BY cliente_nombre ASC LIMIT $inicio,$registros"; 
			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente ORDER BY cliente_nombre ASC LIMIT $inicio,$registros";
			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos = $datos->fetchAll();

			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

			$Npaginas=ceil($total/$registros);

			
			$tabla.='<div class="table-responsive">
				<table class="table table-dark table-sm">
					<thead>
						<tr class="text-center roboto-medium">
							<th>#</th>
                            <th>CC</th>
                            <th>NOMBRE</th>
                            <th>APELLIDO</th>
                            <th>TELEFONO</th>
                            <th>FICHA</th>
                            <th>PROGRAMA</th>
                            <th>INFO</th>';
                            if($privilegio==1 || $privilegio==2){
                                $tabla.='<th>ACTUALIZAR</th>';
                            }
                            if($privilegio==1){
                                $tabla.='<th>ELIMINAR</th>';
                            }
			$tabla.='   </tr>
					</thead>
					<tbody>';

			if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$reg_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
					<tr class="text-center">
                        <td>'.$contador.'</td>
                        <td>'.htmlspecialchars($rows['cliente_dni']).'</td>
                        <td>'.htmlspecialchars($rows['cliente_nombre']).'</td>
                        <td>'.htmlspecialchars($rows['cliente_apellido']).'</td>
                        <td>'.htmlspecialchars($rows['cliente_telefono']).'</td>
                        <td>'.htmlspecialchars($rows['cliente_ficha']).'</td>
                        <td>'.htmlspecialchars($rows['cliente_programa_academico']).'</td>
                        <td>
                            <button type="button" class="btn btn-info" data-toggle="popover" 
                                data-trigger="hover" 
                                title="'.htmlspecialchars($rows['cliente_nombre'].' '.$rows['cliente_apellido']).'" 
                                data-content="'.htmlspecialchars($rows['cliente_direccion']).'">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </td>';

                        if($privilegio==1 || $privilegio==2){
                            $tabla.='<td>
							<a href="'.SERVERURL.'client-update/'.mainModel::encryption($rows['cliente_id']).'/" class="btn btn-success">
									<i class="fas fa-sync-alt"></i>	
							</a>
						</td>';

                        }
                        if($privilegio==1){
                            $tabla.='<td>
                                <form class="FormularioAjax" action="'.SERVERURL.'ajax/clienteAjax.php" method="POST" data-form="delete" autocomplete="off">
                                    <input type="hidden" name="cliente_id_del" value="'.mainModel::encryption($rows['cliente_id']).'">
                                    <button type="submit" class="btn btn-warning">
                                            <i class="far fa-trash-alt"></i>
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
					$tabla.='<tr class="text-center" ><td colspan="9">
					<a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haga clic aca para recargar el listado</a>
					</td></tr>';
				}else{
					$tabla.='<tr class="text-center" ><td colspan="9">No hay registros en el sistema</td></tr>';
				}
			}

			$tabla.='</tbody></table></div>';

			if($total>=1 && $pagina<=$Npaginas){
				$tabla.='<p class="text-right">Mostrando estudientes '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';

				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7);
			}

			return $tabla;
		} /* Fin controlador */

    }
    //Listar clientes
