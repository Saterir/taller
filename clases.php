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
					<div>
						<form action="home1.php" method="post">
							<div>
								<input type="hidden" name="cerrar" value="1"/>
								<input type="submit" value="Cerrar Sesion" style="width:120px; position:relative; top:40px;"/>
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
					<div>
						<form action="home1.php" method="post">
							<div>
								<input type="hidden" name="cerrar" value="1"/>
								<input type="submit" value="Cerrar Sesion" style="width:120px; position:relative; top:40px;"/>
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
	function texteo($datos_texto, $largo) {
		echo'
				<div style="position: relative; left:150px; top:-500px;">
					<div>
						Aplicacion de mensajeria chat
					</div>
					<div Style="width:300px; height:400px; border:1px solid black; overflow-y:auto;">';
					for ($a = ($largo-1); $a > -1; $a--) {
						echo "<div>";
							echo $datos_texto[$a][0];
							//echo $a;
				 		echo  "</div>";
					}
		echo '
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
	/**
	 * crea el formulario donde el admin pone el id del usuario que desa eliminar
	 */
	function formulario_eliminar_usuario() {
		echo'
				<div style="position: relative; left:150px; top:-500px;">
					<div>
						Eliminar usuario
					</div>
					<div>
						<form action="aplicacion.php" method="post">
							<input type="text" name="idUsuarioEliminar"/>
							<input type="submit" value="Eliminar"/>
						</form>
					<div>
				</div>
				';
	}
	/**
	 * crea el formulario que permite crear usuarios en la base de datos
	 */
	function formulario_crear_usuario() {
		echo "
		<!DOCTYPE html>
		<script src='http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha256.js'></script>
		<script>
		function send(){
		var contrasena = '';
		
		contrasena = CryptoJS.SHA256(document.getElementById('contrasenaNuevoUsuario1').value);
		
		document.getElementById('pas').setAttribute('value', contrasena);
		}
		</script>";
		echo'
				<div style="position: relative; left:150px; top:-500px;">
					<div>
						Crear usuario
					</div>
					<div>
						<form action="aplicacion.php" method="post">
							<div>
								Nombre
							</div>
							<div>
								<input type="text" name="nombreNuevoUsuario"/>
							</div>
							<div>
								Contrasena
							</div>
							<div>
								<input id="contrasenaNuevoUsuario1" type="text" />
							</div>
								Atributos de Administrador
							<div>
								<input type="radio" name="nuevoUsuarioAdmin" value="1"/>Si
								<input type="radio" name="nuevoUsuarioAdmin" value="0"/>No
							</div>
							<div>
								<input id="pas" type="hidden" name="contrasenaNuevoUsuario"/>
								<input type="submit" onclick="send()" value="Crear Usuario"/>
							</div>
						</form>
					<div>
				</div>
				';
	}
	/**
	 * Esta funcion permite desplegar el formulario de edicion de usuarios
	 */
	function formulario_para_editar_usuario1() {
		
		echo'
				<div style="position: relative; left:150px; top:-500px;">
					<div>
						Editar Usuario
					</div>
					<div>
						<form action="aplicacion.php" method="post">
							<input type="text" name="idUsuarioEditar"/>
							<input type="submit" value="Buscar Datos"/>
						</form>
					<div>
				</div>
				';
	}
	/**
	 * Este formulario mostara los datos del usuario  con la opcion de editarlos
	 */
	function formulario_para_editar_usuario2($nombre_usuario_edicion,$contrasena_usuario_edicion,$admin_usuario_edicion,$id_aplicaciones_usuario_edicion) {
		
		echo "
		<!DOCTYPE html>
		<script src='http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha256.js'></script>
		<script>
		function send(){
		var contrasena = '';
		
		contrasena = CryptoJS.SHA256(document.getElementById('cuee').value);
		
		document.getElementById('cuee2').setAttribute('value', contrasena);
		}
		</script>";
		
		echo"
				<div style='position: relative; left:150px; top:-500px;'>
					<div>
						Editar Usuario
					</div>
					<div>
						<form action='aplicacion.php' method='post'>
							<div>
								Nombre del usuario
							</div>
							<div>
								<input type='text' value='$nombre_usuario_edicion' name='nuevoNombreEdicion'/>
							</div>
							<div>
								Contraseña del usuario (CUIDADO, cada vez que guardes cambios el codigo va a encriptar la contraseña,<br> 
								por lo que estas obligado a modificarla cadavez que se haga un cambio en el usuario)*
							</div>
							<div>
								<input id='cuee' type='text' value='$contrasena_usuario_edicion'/>
							</div>
							<div>
								Atributos de administracion (1 o 0)
							</div>
							<div>
								<input type='text' value='$admin_usuario_edicion' name='nuevoAdminEdicion'/>
							</div>
							<div>
								<input type='hidden' name='idAplicacionEdicion' value='$id_aplicaciones_usuario_edicion'/>
								<input id='cuee2' type='hidden' name='nuevaContrasenaEdicion'/>
								<input type='submit' onclick='send()' value='Guardar Cambios'/>
							</div>
						</form>
					<div>
				</div>
				";
	}
	
	/**
	 * Esta fincion permite crear el formulario de cambio de contraseña
	 */
	function formulario_cambio_contrasena() {
		echo "
		<!DOCTYPE html>
		<script src='http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha256.js'></script>
		<script>
		function send(){
		var contrasena = '';
		
		contrasena = CryptoJS.SHA256(document.getElementById('cc').value);
		
		document.getElementById('cc2').setAttribute('value', contrasena);
		}
		</script>";
		
		echo"
			<div style='position: relative; left:150px; top:-500px;'>
				<div>
					Cambiar Contrasena
				</div>
				<div>
					<form action='aplicacion.php' method='post'>
						<div>
							<input id='cc' type='text'/>
						</div>
						<div>
							<input id='cc2' type='hidden' name='nuevaContrasenaDelUsuario'/>
							<input type='submit' onclick='send()' value='Cambiar Contrasena'/>
						</div>
					</form>
				<div>
			</div>
			";
	}
}