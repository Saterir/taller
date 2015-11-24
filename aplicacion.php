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
		//$_SESSION['usuario']=$_REQUEST['us'];
		//$_SESSION['contrasena']=$_REQUEST['pas'];
		$_SESSION['usuario']="nico";
		$_SESSION['contrasena']="1234";
	}
}

	$usuario = $_SESSION['usuario'];
	$contrasena = $_SESSION['contrasena'];
	$mysqli = new mysqli($_SERVER["host"], $_SERVER["user"], $_SERVER["pass"], $_SERVER["dbh"]);
	if (!$mysqli->multi_query("SET @p1='$usuario'; SET @p2='$contrasena'; CALL validando(@p1,@p2);")) {
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
		$admin="1";
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
			}elseif (isset($_REQUEST['app']) || $_SESSION['eleccion']=='3') {
				$_SESSION['eleccion']='3';
				echo $aplicacion->texteo();//muestra la aplicacion de texting
			}
		}else {//el caso que el usuario no sea administrador
			if (isset($_REQUEST['config'])) {
				$_SESSION['eleccion']='1';
				echo $aplicacion->configuracion();//muestra el contenido del boton configuracion
			}elseif (isset($_REQUEST['app']) || $_SESSION['eleccion']=='2') {
				$_SESSION['eleccion']='2';
				echo $aplicacion->texteo();//muestra la aplicacion de texting
			}
		}
	}else{
		//el codigo en esta sección se ejecuta solo si el usuario no se encuentra en la db.
		session_destroy();
		echo '<center>algo salio mal<br><a href="home1.php">volver</a></center>';
	}

