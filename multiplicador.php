<?php
function RandomString($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE)
{
	$source = 'abcdefghijklmnopqrstuvwxyz';
	if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	if($n==1) $source .= '1234567890';
	if($sc==1) $source .= '|@#~%=^*+-_';
	if($length>0){
		$rstr = "";
		$source = str_split($source,1);
		for($i=1; $i<=$length; $i++){
			mt_srand((double)microtime() * 1000000);
			$num = mt_rand(1,count($source));
			$rstr .= $source[$num-1];
		}

	}
	return $rstr;
}
for ($i = 0; $i < 1500000; $i++) {
	$usuario=RandomString(7,TRUE,TRUE,TRUE);
	$contrasena=RandomString(15,TRUE,TRUE,TRUE);

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
}
?>