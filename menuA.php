
<html>
	<head>
		<title>Menu</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript">
function setfocus() {
        document.inicio.cod.focus();
        return;
}
</script>
	</head>

	<body onLoad="setfocus()">
		<br>
		<form name="inicio" method="post" action="acceso.php"  target="cuerpo">
			<table>
			<tr>
			<td>&nbsp;</td>
			<td align="center">
			 <strong>
	          <font face="Arial, Helvetica, sans-serif" size="2" color="#FF0000">
			  ACCESO A LA FERIA
			  </font>
	      	  </strong>
			</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			<td align="center">
			 <strong>
	          <font face="Arial, Helvetica, sans-serif" size="2" color="#FF0000">
			  	  <input type="radio" name="acceso" value="entra" checked <?php echo $_SESSION[entra]; ?> onClick="setfocus()">ENTRADA
			  </font>
	      	  </strong>
			</td>
			</tr>
			<tr>
			<td width="100px">&nbsp;</td>
			<td align="center">
			 <strong>
	          <font face="Arial, Helvetica, sans-serif" size="2" color="#FF0000">
			   		<input type="radio" name="acceso" value="sale" <?php echo $_SESSION[sale]; ?> onClick="setfocus()">SALIDA
			   </font>
	      	 </strong>
			</td>
			</tr>
			<tr align="center">
			<td>&nbsp;</td>
			<td align="center">
			</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			<td align="center">
			Código:<br><input type="text" name="cod"><br><br><br>
			<input type="submit" name="enviar" value="Acceso" > &nbsp; &nbsp; &nbsp;
			</td>
			</tr>
			</table>
		</form>
	</body>

</html>