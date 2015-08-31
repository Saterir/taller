<?php 
if (isset($_REQUEST['us']) || isset($_REQUEST['pas'])) {
	$usuario = $_REQUEST['us'];
	$contrasena = $_REQUEST['pas'];
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
		//aquí va el formulario para activar las distintas acciones sobre la db.
		if (isset($_REQUEST["insertarUS"]) || isset($_REQUEST["buscarUS"]) || isset($_REQUEST["eliminarUS"])) {// verifica que  boton presiono y concatena la acción correspondiente. 
			if ($_REQUEST["insertarUS"]==1) {
				if (isset($_REQUEST["NinsertarUS"]) && isset($_REQUEST["CinsertarUS"])) {
					//ejecuta el PA para ingresar usuario
					$usuario_insertar=$_REQUEST["NinsertarUS"];
					$contrasena_insertar=$_REQUEST["CinsertarUS"];
					
					$mysqli = new mysqli($_SERVER["host"], $_SERVER["user"], $_SERVER["pass"], $_SERVER["dbh"]);
					if (!$mysqli->multi_query("SET @p1='$usuario_insertar'; SET @p2='$contrasena_insertar'; CALL insertarusuario(@p1,@p2);")) {
						echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
					}else{
						echo '
							El usuario ha sido registrado correctamente.
							<br>
							<a href="newfile.php">volver</a>
						';
					}
				}else{
					//formulario para agregar un nuevo usuario
					echo "
				<!DOCTYPE html>
				<script src='http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha256.js'></script>
				<script>
					function send(){
						var usuario = '';
						var contrasena = '';
	
						usuario = CryptoJS.SHA256(document.getElementById('usuario').value);
						contrasena = CryptoJS.SHA256(document.getElementById('contrasena').value);
	
						document.getElementById('us').setAttribute('value', usuario);
						document.getElementById('pas').setAttribute('value', contrasena);
					}
				</script>";
				echo '
						<div>
							<form action="newfile.php" method="post">
								<div>
									Agregar nuevo usuario
								</div>
								<div>
									Usuario:
								</div>
								<div>
									<input id="usuario" type="text"/>
								</div>
								<div>
									Contrasena:
								</div>
								<div>
									<input id="contrasena" type="text"/>
								</div>
								<div>
									<input type="hidden" name="us" value='.$usuario.'>
									<input type="hidden" name="pas" value='.$contrasena.'>
									<input id="us" type="hidden" name="NinsertarUS">
									<input id="pas" type="hidden" name="CinsertarUS">
									<input type="submit" onclick="send()" value="ingresar"/>
								</div>
							</form>
						</div>
					';
				}
			}elseif ($_REQUEST["buscarUS"]==2){
				
			}elseif ($_REQUEST["eliminarUS"]==3){
				
			}else{
				echo 'Ha ocurrido un error!!!';
			}
		}else{
			//acontinuacion se puede apreciar el formulario que ve el administrador
			echo '
				<div>
					<div>
						Panel de control
					</div>
					<div>
						<div>
							<form action="validando.php" method="post">
								<div>
					  				<input type="hidden" name="us" value='.$usuario.'>
									<input type="hidden" name="pas" value='.$contrasena.'>
									<input type="hidden" name="insertarUS" value="1">
									<input type="submit" value="Crear usuario">
								</div>
							</form>
						</div>
						<div>
							<form action="validando.php" method="post">
								<div>
					  				<input type="hidden" name="us" value='.$usuario.'>
									<input type="hidden" name="pas" value='.$contrasena.'>
									<input type="hidden" name="buscarUS" value="2">
									<input type="submit" value="Buscar usuario">
								</div>
							</form>
						</div>
						<div>
							<form action="validando.php" method="post">
								<div>
					  				<input type="hidden" name="us" value='.$usuario.'>
									<input type="hidden" name="pas" value='.$contrasena.'>
									<input type="hidden" name="eliminarUS" value="3">
									<input type="submit" value="Eliminar usuario">
								</div>
							</form>
						</div>
					</div>
				</div>
			';
		}
	}else {
		echo 'algo salio mal';
		echo '<a href="home.php">volver</a>';
	}
}else {
	echo '<a href="home.php">volver</a>';
}
?>
