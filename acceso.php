
<?php
	//session_start();
    include("util.php"); // INCLUDE PARA LLAMAR A UNA PAGINA
	include("ControlaBD.php");

	$_POST["cod"] = strtoupper($_POST["cod"]);
	
	if ($_POST[acceso]== "entra"){
		$_SESSION[entra] = "checked='checked'";
		$_SESSION[sale] = "";
	}else{
		$_SESSION[entra] = "";
		$_SESSION[sale] = "checked='checked'";
	}

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("feria2008");
	$hoy = date("Y-m-d");
	$dia = 'D'.date("d");

	//$codigo    = $_POST["cod"];  //recibe el codigo de barra del carnets
	//$EntraSale = $_POST["acceso"]; //recibe si va a manejar como entrada o salida
	
	//Inicio: Valida ingreso un codigo de barra
	if ($_POST["cod"]==''){
	    js_redireccion("error.php?msn=Debe ingresar un codigo de barra"); //ENVIA A LA PAG. ERRO.PHP
		exit;
	} 
	//Fin: Valida ingreso un codigo de barra 
	
	//Inicio: Valida si selecciono o no la Salida o Entrada

	if ($_POST["acceso"]==''){
	    js_redireccion("error.php?msn=Debe Seleccionar si es Entrada o Salida"); //ENVIA A LA PAG. ERRO.PHP
		exit;
	} 
	//Fin: Valida si selecciono o no la Salida o Entrada
    
     $trozo = substr($_POST["cod"], 0, 1); //toma la primera letra del codigo de barra
	 $trozo2 = substr($_POST["cod"], 1, 13); //toma la primera letra del codigo de barra

	 if ($_POST["acceso"]=='entra'){
	    if ($trozo=='A'){ //si la primera letra es "A" es un abono busca en la tabla accesoabono	
				
				$resaccesoab= $con->ejecutar("SELECT * FROM accesoabono WHERE codigo='$_POST[cod]'",$idcon);
			   //$accesoabo = mysql_fetch_array($resaccesoab);
			   $rowabo=mysql_num_rows($resaccesoab);
			   if ($rowabo==0){
				  js_redireccion("error.php?msn=El Abono no Existe"); //ENVIA A LA PAG. ERRO.PHP
				  exit;
			   }else{
			   		$filaabo=mysql_fetch_array($resaccesoab);
					if ($filaabo[$dia] != '0000-00-00 00:00:00'){
						js_redireccion("error.php?msn= La Entrada del día ".substr($dia, 1, 2)." ya fué agotada:<br><br>a las ".substr($filaabo[$dia], 11, 9)."");
					}
					$fecha = date("Y-m-d")." ".(date("H")-1).":".date("i:s");
					//echo "UPDATE accesoabono set $dia = '".$fecha."' WHERE codigo='$_POST[cod]'"; exit;
					$resaccesoab= $con->ejecutar("UPDATE accesoabono set $dia = '".$fecha."' WHERE codigo='$_POST[cod]'",$idcon);
					js_redireccion("conte.php?tipo=A");
			   } 
		     
	    }else{
			//if ($trozo=='C'){
				$resaccesoac= $con->ejecutar("SELECT * FROM acreditado WHERE cod_b like '%$trozo2%'",$idcon);
				$rowacr=mysql_num_rows($resaccesoac);
			//}else{
	       if ($rowacr==0){
				//js_msgbox (substr($_POST[cod], 1, 12));
				//echo "SELECT * FROM acrrot WHERE cod_b = '".substr($_POST[cod], 1, 12)."'";exit;
		      $resaccesoac= $con->ejecutar("SELECT * FROM acrrot WHERE cod_b like '%".substr($_POST[cod], 1, 12)."%'",$idcon);
			  $_POST[cod]=substr($_POST[cod], 2, 12);
		   }
			$rowacr=mysql_num_rows($resaccesoac);	
			//}	
			
	       if ($rowacr==0){
		      js_redireccion("error.php?msn=La Acreditación no existe"); //ENVIA A LA PAG. ERRO.PHP
		      exit;
		   }else{
				$accesacr = mysql_fetch_array($resaccesoac);
				$buscafecha= $con->ejecutar("SELECT * FROM tipacr WHERE codtacr=".$accesacr[tipacr],$idcon);
				$filafecha = mysql_fetch_array($buscafecha);
				$fecha = date("Y-m-d");
				$hora = $fecha." ".(date(H)-1).":".date("i:s");
				//js_msgbox($hora); exit;
				
				if ($fecha < $filafecha['desde']){
				   js_redireccion("error.php?msn=Esta Acreditación permite la entrada a partir del:<br> ".$filafecha['desde']); //ENVIA A LA PAG. ERRO.PHP
				   exit;
				}	
				
				if ($fecha > $filafecha['hasta']){
				   js_redireccion("error.php?msn=Esta Acreditación era válida hasta:<br> ".$filafecha['hasta']); //ENVIA A LA PAG. ERRO.PHP
				   exit;
				}					   
		   
		   
			   if ($accesacr[tipacr]<100){
					if ($_POST["cod"]=='C191641756558'){
						js_redireccion("error.php?msn=ESTA ACREDITACION ESTA BLOQUEADA<BR>NO PERMITIR EL ACCESO");exit;//js_redireccion("error.php?msn=¡¡¡¡¡ El Acreditado está dentro !!!!!<br><br>La credencial debe ser Decomisada");								
					}
			  		if ($accesacr[control]==1){
						js_redireccion("error_cf.php?tipo=C&cod=".$_POST["cod"]);exit;//js_redireccion("error.php?msn=¡¡¡¡¡ El Acreditado está dentro !!!!!<br><br>La credencial debe ser Decomisada");								
					}else{
						if ($trozo=='C'){
							$resaccesoab= $con->ejecutar("UPDATE acreditado set control = 1, contador = contador + 1, ingreso ='".$hora."' WHERE cod_b like '%".$trozo2."%'",$idcon);
							js_redireccion("conte.php?tipo=C&cod=".$_POST["cod"]);exit;
						}else{
							$resaccesoab= $con->ejecutar("UPDATE acrrot set control = 1, contador = contador + 1, ingreso ='".$hora."'  WHERE cod_b like '%".$_POST[cod]."%'",$idcon);
							js_redireccion("conte.php?tipo=R&cod=".$_POST["cod"]);exit;
						}
					}					
				}else{
					if ($accesacr[tipacr]== 133) {
						js_redireccion("error.php?msn=ESTA ACREDITACION NO ES VALIDA"); //ENVIA A LA PAG. ERRO.PHP
						exit;
					}
					
					if ($accesacr[control]==1){
						js_redireccion("error_cf.php?tipo=R&cod=".$_POST["cod"]);exit;					
					}else{
						//if ($accesacr[contador]==99999999){
							//js_redireccion("error.php?msn=Ha excedido la cantidad de accesos para el día");exit;			
						//}else{
							$resaccesoab= $con->ejecutar("UPDATE acrrot set control = 1, contador = contador + 1, ingreso ='".$hora."' WHERE cod_b like '%".$_POST[cod]."%'",$idcon);	
							js_redireccion("conte.php?tipo=R&cod=".$_POST["cod"]);exit;
						//}
					}
			   }	
		}}
	}elseif($_POST["acceso"]=='sale'){
						$_POST[cod]=substr($_POST[cod], 2, 12);
						//js_msgbox($_POST[cod]=substr($_POST[cod], 2, 12));
						if ($trozo=='C'){
							$resaccesoab= $con->ejecutar("UPDATE acreditado set control = 0 WHERE cod_b like '%".$trozo2."%'",$idcon);
							$resaccesoab= $con->ejecutar("UPDATE acrrot set control = 0 WHERE cod_b like '%".$_POST[cod]."%'",$idcon);
							js_redireccion("hl.php");exit;
							
						}else{
							$resaccesoab= $con->ejecutar("UPDATE acrrot set control = 0 WHERE cod_b like '%".$_POST[cod]."%'",$idcon);
							js_redireccion("hl.php");exit;
						}
	} 


?>

