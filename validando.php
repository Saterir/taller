<?php 
if (isset($_REQUEST['us']) || isset($_REQUEST['pas'])) {
	$usuario = $_REQUEST['us'];
	$contrasena = $_REQUEST['pas'];
	//echo $usuario;
	//echo '<br>';
	//echo $contrasena;
	//creando acceso a la base de datos
	//$mysqli = new mysqli("localhost", "admin", "1234", "taller");
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
	if (isset($data)) {//verifica que $data exista, de lo contrario el usuario no esta en la DB
		//aquí va el formulario para activar las distintas acciones sobre la db.
		;
	}
}else {
	echo '<a href="home.php">volver</a>';
}
?>
