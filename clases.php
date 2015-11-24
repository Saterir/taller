<?php
class constructor {
	function cabecera() {
		echo '
			<!DOCTYPE html>
			<head>
				<title>
					Aplicacion
				</title>
			</head>
			<div style="height:100px; background: -webkit-linear-gradient(90deg, #000080,#008080);
				background: -o-linear-gradient(90deg, #000080,#008080); background: -moz-linear-gradient(90deg, #000080,#008080);
				background: linear-gradient(90deg, #000080,#008080); border-radius:10px;">
			</div>';
	}
	
	function fondo() {
		echo '<body style="background-color:#008080;">';
	}
	/**
	 * @param $admin, variable binaria, la cual verifica si la persona es admin o no.
	 * @param $aplicaciones, es un arreglo el cual contiene todas las aplicaciones a la cual posee acceso el usuario.
	 */
	function menu($admin, $aplicaciones) {
		if ($admin==1) {//el usuario es administrador
			echo '
				<div style="position: relative; width: 120px; top:10px; background-color:#000080; height:500px; border-radius:10px;
					border:5px solid #000080;">
					<div>
						<form action="aplicacion.php" method="post">
							<div>
								<input type="hidden" name="cpanel" value="1e"/>
								<input type="submit" value="Cpanel" style="width:120px; position:relative; top:10px;"/>
							</div>
						</form>
					</div>
					<div>
						<form action="aplicacion.php" method="post">
							<div>
								<input type="hidden" name="config" value="1"/>
								<input type="submit" value="Configuracion" style="width:120px; position:relative; top:20px;"/>
							</div>
						</form>
					</div>
					<div>
						<form action="aplicacion.php" method="post">
							<div>
								<input type="hidden" name="app" value="1"/>
								<input type="submit" value="Aplicacion" style="width:120px; position:relative; top:30px;"/>
							</div>
						</form>
					</div>
				</div>
				';
		}else{//el usuario no es administrador
			echo '
				<div style="position: relative; width: 120px; top:10px; background-color:#000080; height:500px; border-radius:10px;
					border:5px solid #000080;">
					<div>
						<form action="aplicacion.php" method="post">
							<div>
								<input type="hidden" name="config" value="1"/>
								<input type="submit" value="Configuracion" style="width:120px; position:relative; top:10px;/>
							</div>
						</form>
					</div>
					<div>
						<form action="aplicacion.php" method="post">
							<div>
								<input type="hidden" name="app" value="1"/>
								<input type="submit" value="Aplicacion" style="width:120px; position:relative; top:20px;"/>
							</div>
						</form>
					</div>
				</div>
				';
		}
	}
	/**
	 * esta funcion se encargara de crear el contenido en el cpanel
	 */
	function cpanel() {
		echo '
			<div style="position: relative; left:150px; top:-500px;">
				<div>
					Menu del CPANEL
				</div>
				<div>
					<form action="aplicacion.php" method="post">
						<input type="hidden" name="eliminarUS" value="1"/>
						<input type="submit" value="Eliminar Usuario"/>
					</form>
				</div>
				<div>
					<form action="aplicacion.php" method="post">
						<input type="hidden" name="crearUS" value="1"/>
						<input type="submit" value="Crear Usuario"/>
					</form>
				</div>
				<div>
					<form action="aplicacion.php" method="post">
						<input type="hidden" name="editarUS" value="1"/>
						<input type="submit" value="Editar Usuario"/>
					</form>
				</div>
				<div>
					<form action="aplicacion.php" method="post">
						<input type="hidden" name="eliminarTA" value="1"/>
						<input type="submit" value="Eliminar Tabla"/>
					</form>
				</div>
				<div>
					<form action="aplicacion.php" method="post">
						<input type="hidden" name="crearTA" value="1"/>
						<input type="submit" value="Crear Tabla"/>
					</form>
				</div>
				<div>
					<form action="aplicacion.php" method="post">
						<input type="hidden" name="editarTA" value="1"/>
						<input type="submit" value="Editar Tabla"/>
					</form>
				</div>
			</div>
			';
	}
	/**
	 * Funcion que se en carga de generar el contenido cuando se presiona el boton configurar
	 */
	function configuracion() {
		echo'
				<div style="position: relative; left:150px; top:-500px;">
					<div>
						Menu de Configuracion
					</div>
					<div>
						<form action="aplicacion.php" method="post">
							<input type="hidden" name="editarCO" value="1"/>
							<input type="submit" value="Editar Contrasena"/>
						</form>
					</div>
				</div>
				';
	}
	/**
	 * Esta aplicacion crea un chat, en el cual el usuario puede enviar y recivir mensajes
	 */
	function texteo() {
		echo'
				<div style="position: relative; left:150px; top:-500px;">
					<div>
						Aplicacion de mensajeria chat
					</div>
					<div Style="width:300px; height:400px; border:1px solid black; overflow-y:auto;">
						//aqui va el contenido que envian todos los demas usuarios :P
					</div>
					<div>
						<form action="aplicacion.php" method="post">
							<input type="text" name="texto" style="width:300px; border:1px solid black;"/>
							<input type="submit" value="Enviar"/>
						</form>
					<div>
				</div>
				';
		
	}
}