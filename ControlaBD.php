<?php
	class ControlaBD{
	   private $idConn;
	   private $dbSelect;

	  function conectarSBD(){
	   $this->idConn =mysql_connect('localhost','root','123456');
	   if (!$this->idConn) {
	      die("Error de conexión al Servidor de Base de Datos: ". mysql_error());
	    }
	    return $this->idConn;
	  }

	  function select_BD($bd){
	    $this->dbSelect = mysql_select_db($bd,$this->idConn);
	    if (!$this->dbSelect) {
	      die ('Error en la selección la Base de Datos:'. mysql_error());
	    }
			return $this->dbSelect;
	  }

	  function ejecutar($strsql,$id){
	    return mysql_query($strsql,$id);
	  }

	  function desconectar(){
	    mysql_close($this->idConn);
	  }
	}
?>