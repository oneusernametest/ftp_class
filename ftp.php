<?php 
/**
 * Clase que se conecta a un servidor Ftp
 * 
 * contiene metodos para subir, borrar ,renombrar y cambiar permisos a directorios y archivos, determinar el tamaño de un archivo
 */
class FTP{

	private $con_ok = false;
	private $connectionId ;
	private $logMsg = array();
	private $server;
	private $user;
	private $password;

	public function __construct($server,$user,$password){
			$this->server = $server;
			$this->user = $user;
			$this->password = $password;
			$this->connect();
	}


	private function connect(){
 
    // configurar la conexion basica
    $this->connectionId = ftp_connect($this->server);
    // acceder al ftp
    $result = ftp_login($this->connectionId, $this->user, $this->password);
    $this->logMsgAdd('Intentando conectar al ' . $this->server . ' con el usuario ' . $this->user.'<br/>');
    echo 'conectando ....';
    // configurar el modo activo
    ftp_pasv($this->connectionId, false);
 
    if ((!$this->connectionId) || (!$result)) {
        $this->logMsgAdd('La conexion al ftp ha fallado!');
        return false;
    } else {
        $this->logMsgAdd('Se ha conectado exitosamente a ' . $this->server . ', con el usuario ' . $this->user.'<br/>');
        $this->con_ok = true;
        return true;
    }
}

 public function deleteFile($file){
 	   if($this->con_ok){
 	   		if(ftp_delete($this->connectionId, $file)){
 	   			$this->logMsgAdd('El archivo '.$file.' fue borrado correctamente<br/>');
 	   			 	   		return true;
 	   		}else{
					$this->logMsgAdd('Error borrando el archivo '.$file.' <br/>');
 	   		}

 	   }else{
 	   	  $this->logMsgAdd('Error Borrando archivo, No hay conexion activa con el servidor ftp'.'<br/>');
 	   }
 	  return false;

 }


 public function uploadFile($file){
 	 	if($this->con_ok){
 		if (ftp_put($this->connectionId, $this->server, $file, FTP_ASCII)) {

  $this->logMsgAdd('El archivo '.$file.'se ha cargado exitosamente <br />');

 			return true;
		} else {
			  $this->logMsgAdd('Ha fallado al cargar el archivo <br />');

		}
	}else{
		$this->logMsgAdd('Error Cargando archivo ,No hay conexion activa con el servidor ftp <br />');
	}
		return false;
 }


 public function closeConnection(){
 			if($this->con_ok){
 				ftp_close($this->connectionId);
 			$this->logMsgAdd('La conexion con el servidor ftp se ha cerrado correctamente <br />');
	}
 }


 public function chmodFile($file, $permission){
 		if (ftp_chmod($this->connectionId, $permission, $file) !== false) {
         $this->logMsgAdd('Actualizado archivo con nuevo permiso'.$permission .'<br />');
         return true;
} else {
 		$this->logMsgAdd('No se ha podido actualizar el archivo con permiso '.$permission .'<br />');
}

 }

 public function chmodFolder($folder,$permission){
	if (ftp_chmod($this->connectionId, $permission, $file) !== false) {
         $this->logMsgAdd('Actualizado el directorio con nuevo permiso'.$permission .'<br />');
         return true;
} else {
 		$this->logMsgAdd('No se ha podido actualizar el directorio con permiso '.$permission .'<br />');
}
 }


 public function renameFile($old_file, $new_file){
 	if (ftp_rename($this->connectionId, $old_file, $new_file)) {
 		$this->logMsgAdd('El archivo '.$old_file. '  ha sido  renombrado a '.$new_file.'<br />');
} else {
			$this->logMsgAdd('Hubo un problema al renombrar el archivo'.'<br />');
}

 }

 public function renameFolder($old_folder, $new_folder){
 		if (ftp_rename($this->connectionId, $old_folder, $new_folder)) {
 		$this->logMsgAdd('El directorio'.$old_folder. '  ha sido  renombrado a '.$new_folder.'<br />');
} else {
			$this->logMsgAdd('Hubo un problema al renombrar el directorio'.'<br />');
}

 }

 public function sizeOfFile($file){

 		$size = ftp_size($this->connectionId, $file);
 		if ($size!= -1) {
 			$this->logMsgAdd('El tamaño del archivo '.$file .'es '. $size .' bytes <br />');
 			return $size;
 		}else{
 				$this->logMsgAdd('No se puede determinar el tamaño del archivo'.$file .'es <br />');
 		}
 		return false;
 }
public function logMsgAdd($msg){
		array_push($this->logMsg,$msg);
}


public function showLog(){
	foreach ($this->logMsg as $key) {
		echo $key;
	}
}


}