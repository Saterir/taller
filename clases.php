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
								<input type="hidden" name="cpanel" value="1"/>
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
						<form action="aplicacion.php" method="post">
							<div>
								<input type="hidden" name="menu" value="1"/>
								<input type="submit" value="Menu" style="width:120px; position:relative; top:40px;"/>
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
					<div>
						<form action="aplicacion.php" method="post">
							<div>
								<input type="hidden" name="menu" value="1"/>
								<input type="submit" value="Menu" style="width:120px; position:relative; top:30px;"/>
							</div>
						</form>
					</div>
				</div>
				';
		}
	}
}