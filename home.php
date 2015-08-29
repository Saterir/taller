<?php
//genera nombre de las variables random
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
$nombre = RandomString(15,TRUE,TRUE,TRUE);
$contrasena = RandomString(17,TRUE,TRUE,TRUE);
$ID_Nombre = RandomString(18,TRUE,TRUE,TRUE);
$ID_contrasena = RandomString(19,TRUE,TRUE,TRUE);
// formulario
echo "
	<!DOCTYPE html>
		<script src='http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha256.js'></script>
		<script>
			function send(){
			var usuario = '';
			var contrasena = '';

			usuario = CryptoJS.SHA256(document.getElementById('$nombre').value);
			contrasena = CryptoJS.SHA256(document.getElementById('$contrasena').value);
	
			document.getElementById('us').setAttribute('value', usuario);
			document.getElementById('pas').setAttribute('value', contrasena);
			}
		</script>";
echo "
	<div>
		<form action='validando.php' method='post'>
			<div>
				Formulario
			</div>
			<div>
				Nombre:
			</div>
			<div>
				<input id='$nombre' type='text'/>
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
						<input id='us' type='hidden' name='us'>
						<input id='pas' type='hidden' name='pas'>
						<input type='submit' onclick='send()' value='Ingresar'>
					</div>
				</div>
			</div>
		</form>
	</div>
";
?>
