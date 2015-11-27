<?php
	$contrasena='1234';
	for ($i = 0; $i < 1000000; $i++) {
		$usuario=$i;
		$mysqli = new mysqli($_SERVER["host"], $_SERVER["user"], $_SERVER["pass"], $_SERVER["dbh"]);
		if (!$mysqli->multi_query("SET @p1='$usuario'; SET @p2='$contrasena'; 
					SET @p3='0'; SET @p4='1'; SET @p5='';
					CALL crear_usuario(@p1,@p2,@p3,@p4,@p5);")) {
			echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
		}
	}
?>	
	