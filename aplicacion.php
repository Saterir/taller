<?php
//1 debe verificar si el usuario esxiste o no en la base de datos, de no exister te envia de vuelta a home1.php
// pero si existe aplica el formato estandar para la pagina
//2 debe verificar si el usuario es admin o no
//3 si es admin aparece un boton en menu para el cpanel, de lo contrario no se activa

require_once 'clases.php';
session_start();
if (isset($_SESSION['usuario'])==false || isset($_SESSION['contrasena'])==false) {
	if (empty($_REQUEST['us'])==true || empty($_REQUEST['pas'])==true) {
		exit();
	}else {
		$_SESSION['usuario']=$_REQUEST['us'];
		$_SESSION['contrasena']=$_REQUEST['pas'];
		//$_SESSION['usuario']="nico";
		//$_SESSION['contrasena']="1234";
	}
}

	$usuario = $_SESSION['usuario'];
	$contrasena = $_SESSION['contrasena'];
	$mysqli = new mysqli($_SERVER["host"], $_SERVER["user"], $_SERVER["pass"], $_SERVER["dbh"]);
	if (!$mysqli->multi_query("SET @p1='$usuario'; SET @p2='$contrasena'; CALL login(@p1,@p2);")) {
    	echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	/*Ahora con este bucle recogemos los resultados y los recorremos*/
	do {
    	/*En el if recogemos una fila de la tabla*/
    	if ($res = $mysqli->store_result()) { 
        	/*Imprimimos el resultado de la fila y debajo un salto de línea*/
        	$data=$res->fetch_all();
        	$id_usuario=$data[0][0];//obtiene el ID del usuario
        	/*La llamada a free() no es obligatoria, pero si recomendable para aligerar memoria y para evitar problemas si después hacemos una llamada a otro procedimiento*/
        	$admin=$data[0][3];
        	$res->free();
    	} else {
        if ($mysqli->errno) {
            echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
    }
	} while ($mysqli->more_results() && $mysqli->next_result());
	/*El bucle se ejecuta mientras haya más resultados y se pueda saltar al siguiente*/
	if (isset($id_usuario)) {//verifica que $data exista, de lo contrario el usuario no esta en la DB
		//contenido de la pagina
		$aplicacion = new constructor; //creamos la variable aplicacion, la cual contiene a la clase constructor
		echo $aplicacion->cabecera(); //invocamos la cabecera de la pagina.
		echo $aplicacion->fondo(); //crea el color de fondo de la pagina.
		//$admin="0";
		$app="1";
		echo $aplicacion->menu($admin, $app);
		
		if ($admin='1') {//verifica si es administrador
			if (isset($_REQUEST['cpanel'])) {
				if ($_REQUEST['cpanel']=='1e') {
					$_SESSION['eleccion']='1';
					echo $aplicacion->cpanel();//muestra el cpanel
				}else{
					echo 'OPCION NO VALIDA PARA ESTE USUARIO';
				}
			}elseif (isset($_REQUEST['config'])) {
				$_SESSION['eleccion']='2';
				echo $aplicacion->configuracion();//muestra el contenido del boton configuracion
			}elseif (isset($_REQUEST['app']) || $_SESSION['irApp']=='1') {
				$_SESSION['eleccion']='3';
				$_SESSION['irApp']='0';
				//insertar PA
				echo $aplicacion->texteo();//muestra la aplicacion de texting
			}elseif ($_SESSION['eleccion']=='1' && $_REQUEST['eliminarUS']=='1'){
				//entra en este if, si el usuario hizo click en eliminar usuario dentro de cplanel
				$_SESSION['eliminarUS']='1'; 
				//generar formilario
				echo $aplicacion->formulario_eliminar_usuario();
			}elseif ($_SESSION['eleccion']=='1' && $_SESSION['eliminarUS']=='1' && isset($_REQUEST['idUsuarioEliminar'])==true){
				//poner PA
				$idusuarioEliminar=$_REQUEST['idUsuarioEliminar'];
				if (!$mysqli->multi_query("SET @p1='$idusuarioEliminar'; SET @p2=''; CALL borrar_usuario(@p1,@p2);")) {
					echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				/*Ahora con este bucle recogemos los resultados y los recorremos*/
				do {
					/*En el if recogemos una fila de la tabla*/
					if ($res = $mysqli->store_result()) {
						/*Imprimimos el resultado de la fila y debajo un salto de línea*/
						$data=$res->fetch_all();
					    var_dump($data);
						$res->free();
					} else {
						if ($mysqli->errno) {
							echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
						}
					}
				} while ($mysqli->more_results() && $mysqli->next_result());
				/*El bucle se ejecuta mientras haya más resultados y se pueda saltar al siguiente*/
				//verifica que todo alla salido bien
				
				//cambiar estado de variable a 0
				$_SESSION['eliminarUS']='0';
			}elseif ($_SESSION['eleccion']=='1' && $_REQUEST['crearUS']=='1'){//despliega el menu para crear usuarios dentro del cpanel
				$_SESSION['crearUS']='1';
				//genera el formunalrio para crear usuario
				echo $aplicacion->formulario_crear_usuario();
			}elseif ($_SESSION['eleccion']=='1' && $_SESSION['crearUS']=='1' && isset($_REQUEST['nombreNuevoUsuario']) &&
					isset($_REQUEST['contrasenaNuevoUsuario']) && isset($_REQUEST['nuevoUsuarioAdmin'])) {
				//poner el PA
				$nombre_nuevo_usuario=$_REQUEST['nombreNuevoUsuario'];
				$contrasena_nuevo_usuario=$_REQUEST['contrasenaNuevoUsuario'];
				$admin_nuevo_usuario=$_REQUEST['nuevoUsuarioAdmin'];
				$aplicadiones_nuevo_usuario='1';
				if (!$mysqli->multi_query("SET @p1='$nombre_nuevo_usuario'; SET @p2='$contrasena_nuevo_usuario'; 
				SET @p3='$admin_nuevo_usuario'; SET @p4='$aplicadiones_nuevo_usuario'; SET @p5=''; CALL crear_usuario(@p1,@p2,@p3,@p4,@p5);")) {
					
					echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				/*Ahora con este bucle recogemos los resultados y los recorremos*/
				do {
					/*En el if recogemos una fila de la tabla*/
					if ($res = $mysqli->store_result()) {
						/*Imprimimos el resultado de la fila y debajo un salto de línea*/
						$data=$res->fetch_all();
						var_dump($data);
						$res->free();
					} else {
						if ($mysqli->errno) {
							echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
						}
					}
				} while ($mysqli->more_results() && $mysqli->next_result());
				/*El bucle se ejecuta mientras haya más resultados y se pueda saltar al siguiente*/
				//verifica que todo este bien
				
				//dejar en estatus 0 la variable 
				$_SESSION['crearUS']='0';
			}elseif ($_SESSION['eleccion']=='1' && $_REQUEST['editarUS']=='1') {//editar usuario
				$_SESSION['editarUS']='1';
				//genera el formunalrio para buscar los datos del usuario que se desea editar
				echo $aplicacion->formulario_para_editar_usuario1();
			}elseif ($_SESSION['eleccion']=='1' && $_SESSION['editarUS']=='1' && isset($_REQUEST['idUsuarioEditar'])){
				$_SESSION['idUsuarioEditar']=$_REQUEST['idUsuarioEditar'];
				$_SESSION['editarUsuario']='1';
				$idusuarioEditar=$_SESSION['idUsuarioEditar'];
				//con un PA busca los datos del usuario correspondiente al id y almacenarlos en variables
				if (!$mysqli->multi_query("SET @p1='$idusuarioEditar'; CALL info_usuario(@p1);")) {
					echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				/*Ahora con este bucle recogemos los resultados y los recorremos*/
				do {
					/*En el if recogemos una fila de la tabla*/
					if ($res = $mysqli->store_result()) {
						/*Imprimimos el resultado de la fila y debajo un salto de línea*/
						$data=$res->fetch_all();
						$nombre_usuario_edicion=$data[0][1];//obtiene el ID del usuario
        				$contrasena_usuario_edicion=$data[0][2];
        				$admin_usuario_edicion=$data[0][3];
        				$id_aplicaciones_usuario_edicion='1';
        				//var_dump($data);
						$res->free();
					} else {
						if ($mysqli->errno) {
							echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
						}
					}
				} while ($mysqli->more_results() && $mysqli->next_result());
				/*El bucle se ejecuta mientras haya más resultados y se pueda saltar al siguiente*/
				//genera un formulario en donde muestra los datos obtenidos y con la opcion de editarlos
				echo $aplicacion->formulario_para_editar_usuario2($nombre_usuario_edicion,$contrasena_usuario_edicion,$admin_usuario_edicion,$id_aplicaciones_usuario_edicion);
			}elseif ($_SESSION['eleccion']=='1' && $_SESSION['editarUS']=='1' && $_SESSION['editarUsuario']=='1' &&
					isset($_REQUEST['nuevoNombreEdicion']) && isset($_REQUEST['nuevoAdminEdicion']) &&
					isset($_REQUEST['idAplicacionEdicion']) && isset($_REQUEST['nuevaContrasenaEdicion'])){//ingresa en esta causal, solo si se han enviado los datos para editar
				$nombre_usuario_edicion1=$_REQUEST['nuevoNombreEdicion'];
				$contrasena_usuario_edicion1=$_REQUEST['nuevaContrasenaEdicion'];
				$admin_usuario_edicion1=$_REQUEST['nuevoAdminEdicion'];
				$id_aplicaciones_usuario_edicion1=$_REQUEST['idAplicacionEdicion'];
				$idusuarioEditar1=$_SESSION['idUsuarioEditar'];
				//se actualizan los datos con un PA
				if (!$mysqli->multi_query("SET @p1='$idusuarioEditar1'; SET @p2='$nombre_usuario_edicion1'; 
						SET @p3='$contrasena_usuario_edicion1'; SET @p4='$admin_usuario_edicion1'; 
						SET @p5='$id_aplicaciones_usuario_edicion1';SET @p6=''; CALL editar_usuario(@p1,@p2,@p3,@p4,@p5,@p6);")) {
					echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				/*Ahora con este bucle recogemos los resultados y los recorremos*/
				do {
					/*En el if recogemos una fila de la tabla*/
					if ($res = $mysqli->store_result()) {
						/*Imprimimos el resultado de la fila y debajo un salto de línea*/
						$data=$res->fetch_all();
						$res->free();
					} else {
						if ($mysqli->errno) {
							echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
						}
					}
				} while ($mysqli->more_results() && $mysqli->next_result());
				/*El bucle se ejecuta mientras haya más resultados y se pueda saltar al siguiente*/
				//deja los status en 0
				$_SESSION['editarUS']='0';
				$_SESSION['editarUsuario']='0';
			}elseif ($_SESSION['eleccion']=='2' && $_REQUEST['editarCO']=='1'){ //despliega menu para editar contraseña en el item configuracion
				$_SESSION['editarCO']='1';
				//despliega el menu para cambiar contraseña
				echo $aplicacion->formulario_cambio_contrasena();
			}elseif ($_SESSION['eleccion']=='2' && $_SESSION['editarCO']=='1' && isset($_REQUEST['nuevaContrasenaDelUsuario'])){
				//insertar PA para cambio de contraseña
				$nueva_contrasena_del_usuario=$_REQUEST['nuevaContrasenaDelUsuario'];
				if (!$mysqli->multi_query("SET @p1='$id_usuario'; SET @p2='$nueva_contrasena_del_usuario'; SET @p3='';
						CALL editar_contraseña(@p1,@p2,@p3);")) {
						echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				/*Ahora con este bucle recogemos los resultados y los recorremos*/
				do {
					/*En el if recogemos una fila de la tabla*/
					if ($res = $mysqli->store_result()) {
						/*Imprimimos el resultado de la fila y debajo un salto de línea*/
						$data=$res->fetch_all();
						$res->free();
					} else {
						if ($mysqli->errno) {
							echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
						}
					}
				} while ($mysqli->more_results() && $mysqli->next_result());
				/*El bucle se ejecuta mientras haya más resultados y se pueda saltar al siguiente*/
				//reseteando variable
				$_SESSION['editarCO']='0';
			}elseif ($_SESSION['eleccion']=='3' && isset($_REQUEST['texto'])){//mandar la informacion que el usuario desea compartir con los demas
				$texto_usuario=$_REQUEST['texto'];
				//ejecuta PA, para subir lo enviado a la base de datos
				if (!$mysqli->multi_query("SET @p1='$texto_usuario'; SET @p2='$id_usuario';
						CALL texto(@p1,@p2);")) {
						echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				/*Ahora con este bucle recogemos los resultados y los recorremos*/
				do {
					/*En el if recogemos una fila de la tabla*/
					if ($res = $mysqli->store_result()) {
						/*Imprimimos el resultado de la fila y debajo un salto de línea*/
						$data=$res->fetch_all();
						$res->free();
					} else {
						if ($mysqli->errno) {
							echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
						}
					}
				} while ($mysqli->more_results() && $mysqli->next_result());
				/*El bucle se ejecuta mientras haya más resultados y se pueda saltar al siguiente*/
				$_SESSION['irApp']='1';//esta variable nos permite retornan a la aplicacion
				//hay que refrescar la pagina
				header("Refresh:0");
			}
		}else {//el caso que el usuario no sea administrador
			if (isset($_REQUEST['config'])) {
				$_SESSION['eleccion']='2';
				echo $aplicacion->configuracion();//muestra el contenido del boton configuracion
			}elseif (isset($_REQUEST['app']) || $_SESSION['irApp']=='1') {
				$_SESSION['eleccion']='3';
				$_SESSION['irApp']='0';
				echo $aplicacion->texteo();//muestra la aplicacion de texting
			}elseif ($_SESSION['eleccion']=='2' && $_REQUEST['editarCO']=='1'){ //despliega menu para editar contraseña en el item configuracion
				$_SESSION['editarCO']='1';
				//despliega el menu para cambiar contraseña
				echo $aplicacion->formulario_cambio_contrasena();
			}elseif ($_SESSION['eleccion']=='2' && $_SESSION['editarCO']=='1' && isset($_REQUEST['nuevaContrasenaDelUsuario'])){
				//insertar PA para cambio de contraseña
				$nueva_contrasena_del_usuario=$_REQUEST['nuevaContrasenaDelUsuario'];
				if (!$mysqli->multi_query("SET @p1='$id_usuario'; SET @p2='$nueva_contrasena_del_usuario'; SET @p3='';
						CALL editar_contraseña(@p1,@p2,@p3);")) {
						echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				/*Ahora con este bucle recogemos los resultados y los recorremos*/
				do {
					/*En el if recogemos una fila de la tabla*/
					if ($res = $mysqli->store_result()) {
						/*Imprimimos el resultado de la fila y debajo un salto de línea*/
						$data=$res->fetch_all();
						$res->free();
					} else {
						if ($mysqli->errno) {
							echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
						}
					}
				} while ($mysqli->more_results() && $mysqli->next_result());
				/*El bucle se ejecuta mientras haya más resultados y se pueda saltar al siguiente*/
				//reseteando variable
				$_SESSION['editarCO']='0';
			}elseif ($_SESSION['eleccion']=='3' && isset($_REQUEST['texto'])){//mandar la informacion que el usuario desea compartir con los demas
				$texto_usuario=$_REQUEST['texto'];
				//ejecuta PA, para subir lo enviado a la base de datos
				if (!$mysqli->multi_query("SET @p1='$texto_usuario'; SET @p2='$id_usuario';
						CALL texto(@p1,@p2);")) {
						echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				/*Ahora con este bucle recogemos los resultados y los recorremos*/
				do {
					/*En el if recogemos una fila de la tabla*/
					if ($res = $mysqli->store_result()) {
						/*Imprimimos el resultado de la fila y debajo un salto de línea*/
						$data=$res->fetch_all();
						$res->free();
					} else {
						if ($mysqli->errno) {
							echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
						}
					}
				} while ($mysqli->more_results() && $mysqli->next_result());
				/*El bucle se ejecuta mientras haya más resultados y se pueda saltar al siguiente*/
				$_SESSION['irApp']='1';//esta variable nos permite retornan a la aplicacion
				//hay que refrescar la pagina
				header("Refresh:0");
			}
		}
	}else{
		//el codigo en esta sección se ejecuta solo si el usuario no se encuentra en la db.
		session_destroy();
		echo '<center>algo salio mal<br><a href="home1.php">volver</a></center>';
	}

