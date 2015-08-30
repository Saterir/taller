<?php
if (isset($_REQUEST["us"]) && $_REQUEST["pas"]) {
	$usuario=$_REQUEST["us"];
	$contrasena=$_REQUEST["pas"];
	
	$mysqli = new mysqli($_SERVER["host"], $_SERVER["user"], $_SERVER["pass"], $_SERVER["dbh"]);
	if (!$mysqli->multi_query("SET @p1='$usuario'; SET @p2='$contrasena'; CALL insertarusuario(@p1,@p2);")) {
		echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
	}else{
		echo '
			El usuario ha sido registrado correctamente.
			<br>
			<a href="newfile.php">volver</a>
			';
	    }
	
	
}else{
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
				<input id="usuario" type="text" name="usuario"/>
			</div>
			<div>
				Contrasena:
			</div>
			<div>
				<input id="contrasena" type="text" name="contrasena"/>
			</div>
			<div>
				<input id="us" type="hidden" name="us">
				<input id="pas" type="hidden" name="pas">
				<input type="submit" onclick="send()" value="ingresar"/>
			</div>
		</form>
	</div>
';
}
?>