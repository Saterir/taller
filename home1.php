<?php
	//crear formulario de acceso a la apricacion, debe enviar la clave encriptada
class accseso {
	/**funcion que permite encriptar la informacion enviada, con el fin de evitar que obtengan de 
	 * forma facil el contraseña del sujeto
	 * @param $contrasena, es el id del campo que se desea encriptar
	 */
	function encriptarSha256($contrasena) {
		echo "
		<!DOCTYPE html>
		<script src='http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha256.js'></script>
		<script>
			function send(){
			var contrasena = '';

			contrasena = CryptoJS.SHA256(document.getElementById('$contrasena').value);
	
			document.getElementById('pas').setAttribute('value', contrasena);
			}
		</script>";
	}
	/**
	 * @param $pagina, es la variable la cual nos dice hacia donde va a enviar la informacion el formulario
	 * @param $contrasena, es la variable que le da el id al campo donde se ingresa la contraseña
	 */
	function formulario($pagina, $contrasena) {
		echo "	
		<div>
		<center>
		<form action='$pagina' method='post' style='border: 1px solid black; width: 200px; border-radius:10px;'>
		<div>	
			<div>
				Formulario
			</div>
			<div>
				Nombre:
			</div>
			<div>
				<input type='text' name='us'/>
			</div>
			<div>
				<div>
					<div>
						Contrasena:
					</div>
					<div>
						<input id='$contrasena' type='password'/>
					</div>
				</div>
				<div>
					<div>
						<input id='pas' type='hidden' name='pas'>
						<input type='submit' onclick='send()' value='Ingresar'>
					</div>
				</div>
			</div>
		</div>
		</form>
		</center>
	</div>";
	}
}
$form = new accseso;
$id_contrasena="pass";
$pagina = "aplicacion.php";
echo $form->encriptarSha256($id_contrasena);
echo $form->formulario($pagina, $id_contrasena);