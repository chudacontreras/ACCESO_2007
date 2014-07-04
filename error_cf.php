<?php
	session_start();
    include("util.php"); // INCLUDE PARA LLAMAR A UNA PAGINA
	include("ControlaBD.php");	
	
	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("feria2008");	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Control de Acceso</title>
</head>
<body>
<?php
if ($_GET['tipo']=='A'){
?>
<table width="750" border="0" align="center">
  <tr>
    <td width="25%"><?php include("menuA.php"); ?></td>
    <td><img src="Imagenes/Bien.jpg"></td>
  </tr>
</table>
<?php
}elseif ($_GET['tipo']=='C'){
?>
<table width="750" border="0" align="center">
  <tr>
    <td width="25%"><?php include("menuA.php"); ?></td>
    <td align="center">
	<div align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#FF0000; background-color:#FFFF00">
		<img src="Imagenes/Bien_0.jpg">
	<div align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:30px; color:#FF0000; background-color:#FFFF00">
		El Acreditado est&aacute; dentro<br>la acreditaci&oacute;n debe ser decomisada<br><br>
	</div>			
		<?php 

			$buscaacre= $con->ejecutar("SELECT * FROM acreditado WHERE cod_b='".$_GET['cod']."'",$idcon);
			//echo "SELECT * FROM acreditado WHERE cod_b='".$_GET['cod']."'";
			$filaacre = mysql_fetch_array($buscaacre);
			$buscaemp= $con->ejecutar("SELECT * FROM empresa WHERE rif='".$filaacre['rif']."'",$idcon);
			$filaemp = mysql_fetch_array($buscaemp);
			echo "<img src='".$filaacre['foto']."'><br><br>";
			echo "<strong>".$filaacre['nombre']."</strong><br>";
			echo "<strong>".$filaacre['cedula']."</strong><br>";
			echo "<strong>Empresa: ".$filaemp['nombre']."</strong><br>";
			echo "<strong>Ultimo acceso: ".$filaacre['ingreso']."</strong><br>";
		?>
		<img src="Imagenes/Bien_3.jpg">
	</div>
	</td>
  </tr>
</table>
<?php
}else{
?>
<table width="750" border="0" align="center">
  <tr>
    <td width="25%"><?php include("menuA.php"); ?></td>
    <td align="center">	
	<div align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#FF0000; background-color:#FFFF00">
		<img src="Imagenes/Bien_0.jpg">
	<div align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:30px; color:#FF0000; background-color:#FFFF00">
		El Acreditado est&aacute; dentro<br>la acreditaci&oacute;n debe ser decomisada<br><br>
	</div>			
		<?php 
		
			$buscaacre= $con->ejecutar("SELECT * FROM acrrot WHERE cod_b like '%".$_GET['cod']."%'",$idcon);
			$filaacre = mysql_fetch_array($buscaacre);
			$buscaemp= $con->ejecutar("SELECT * FROM empresa WHERE rif='".$filaacre['rif']."'",$idcon);
			$filaemp = mysql_fetch_array($buscaemp);

			$cadena = $filaacre['cod_v'];
			if (strlen($cadena)<3){
				$cont = strlen($cadena);
				while ($cont < 3){
				$cadena = "0".$cadena;
				$cont++;
				}
			}		
			echo "<strong>".$cadena."</strong><br>";
			echo "<strong>Empresa: ".$filaemp['nombre']."</strong><br>";
			echo "<strong>Ultimo acceso: ".$filaacre['ingreso']."</strong><br>";
		?>
		<img src="Imagenes/Bien_3.jpg">
	</div>
	</td>
  </tr>
</table>
<?php
}
?>
</body>
</html>
