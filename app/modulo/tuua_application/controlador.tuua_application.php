<?php
date_default_timezone_set('America/Lima');
ini_set('max_execution_time',0);
ini_set('memory_limit', '300M');
ini_set('display_errors', 'Off');
error_reporting();
class tuua_application extends App{
    public function index(){
      if(!isset($_SESSION["usuario"])){
          $this->vista->reenviar("index", "acceso");
      }
      $this->vista->setTitle("Inicio");
    }
    public function cerrar(){
      unset($_SESSION);
      session_destroy();
      $this->vista->reenviar("index");
    }
    public function getStamp(){
      $now = (string)microtime();
      $now = explode(' ', $now);
      $mm = explode('.', $now[0]);
      $mm = $mm[1];
      $now = $now[1];
      $segundos = $now % 60;
      $segundos = $segundos < 10 ? "$segundos" : $segundos;
      return strval(date("YmdHi",mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))) . "$segundos$mm");
  }

  public function ta_listado_vuelos(){}
  public function init_listado_vuelos(){
    $modelo = new modeloTuua_application();
    $sql="SELECT * FROM usuario u  WHERE u.idusuario=:idusuario";
    $resulta= $modelo->executeQuery( $sql,array("idusuario"=>$_SESSION["ck_id_usuario_ini"]) );
    for($i=0;$i<count($resulta);$i=$i+1)
    {
      $estacion=$resulta[$i]["idEstacion"];		
    }
    $fecha_ini 	= "";
    $fecha_fin 	= "";
    $origen 	= "";
    $idFileTuua = "";
        if( isset($_REQUEST["fecha_ini"])){				
          $fecha_ini 	= 	$_REQUEST["fecha_ini"];
          $fecha_fin 	= 	$_REQUEST["fecha_ini"];
          $origen 	= 	$_REQUEST["aeroEmbarque"];
          $idFileTuua = 	$_REQUEST["idFileTuua"];
                    
          switch ($estacion) {
            case 15: $origen = "CUZ";  $disabled="disabled"; break;
            case 17: $origen = "PIU";  $disabled="disabled"; break;
            case 18: $origen = "IQT";  $disabled="disabled"; break;
            case 23: $origen = "PCL";  $disabled="disabled"; break;
            case 26: $origen = "TPP";  $disabled="disabled"; break;
            case 16: $origen = "AQP";  $disabled="disabled"; break;
            case 19: $origen = "TCQ";  $disabled="disabled"; break;
                  
            } 
                              
          $_SESSION["fecVueloTip"]="";
          $_SESSION["fecVueloTip"]="";
          $_SESSION["aeroEmbarque"]="";
          
          }else{
          
            
            if(!(isset($_SESSION["fecVueloTip"]) && $_SESSION["fecVueloTip"]== "")){
                  
                  $fecha_ini = date('Y-m-d', time());
                  $fecha_fin = date('Y-m-d', time());
                  $origen 	= 	""; 
                  
                    
                switch ($estacion) {
                  case 15: $origen = "CUZ";  $disabled="disabled"; break;
                  case 17: $origen = "PIU";  $disabled="disabled"; break;
                  case 18: $origen = "IQT";  $disabled="disabled"; break;
                  case 23: $origen = "PCL";  $disabled="disabled"; break;
                  case 26: $origen = "TPP";  $disabled="disabled"; break;
                  case 16: $origen = "AQP";  $disabled="disabled"; break;
                  case 19: $origen = "TCQ";  $disabled="disabled"; break;
                  default: $origen = ""; $disabled = "";			 
                  } 
            
                  }else{
                  
                  
            
                  $fecha_ini 	= 	$_SESSION["fecVueloTip"];
                  $fecha_fin 	= 	$_SESSION["fecVueloTip"];
                  $origen 	= 	$_SESSION["aeroEmbarque"];
                  
                  $_SESSION["fecVueloTip"]="";
                  $_SESSION["fecVueloTip"]="";
                  $_SESSION["aeroEmbarque"]="";
                  
                  }					
            }
        echo json_encode(array("origen"=>$origen,"disabled"=>$disabled,"fecha_ini"=>$fecha_ini,"fecha_fin"=>$fecha_fin,"idFileTuua"=>$idFileTuua));
  }
  public function init_ta_listado_vuelos_kiu(){
    $pasajero=$_REQUEST["txtpasajero"] . "%";
    $fe1=$_REQUEST["fecha1"];
    $fe2=$_REQUEST["fecha2"];
    $origen=$_REQUEST["origen"];

    $modelo = new modeloTuua_application();
    $response = $modelo->tuua_cabecera(array("origen"=>$origen,"fe1"=>$fe1,"fe2"=>$fe2));

    echo json_encode(array("data"=>$response));
  }
  public function AdpController(){
    require_once("clases/EnviarTuaDAO.php");
    $flag = isset($_REQUEST["flag"])?$_REQUEST["flag"]:"";
    if($flag=="CrearManifiesto"){
      $etd=new EnviarTuaDAO();
      $fecha_vuelo=$_REQUEST["fecha_vuelo"];
      $nro_vuelo=$_REQUEST["nro_vuelo"];
      $origen=$_REQUEST["origen"];
      $hora_despegue=$_REQUEST["hora_despegue"];
      $hora_cierra_despegue=$_REQUEST["hora_cierra_despegue"];
      $hora_llegada_destino=$_REQUEST["hora_llegada_destino"];
      $matricula_avion=$_REQUEST["matricula_avion"];
      try {
        $result = $etd->insertarCabecera($fecha_vuelo,$nro_vuelo,$origen,$hora_despegue,$hora_cierra_despegue,$hora_llegada_destino,$matricula_avion);			
        if (!$result) {
          new Exception("Ha ocurrido un error al insertar los registros");
        }
      } catch (Exception $e) {
        echo json_encode(array("result"=>"Error","mensaje"=>$e,"icon"=>"error"));
      }
      echo json_encode(array("result"=>"Completado","mensaje"=>"Ha terminado el proceso con éxito","icon"=>"success"));
    }
    if($flag=="ImportarPax")
    {
      $etd=new EnviarTuaDAO();	
      $idFileTuua=$_REQUEST["idFileTuua"];
      $FechaUso=$_REQUEST["Fecha"];
      $LocOrigen=$_REQUEST["aeroEmbarque"];
      $LocDestino=$_REQUEST["LocDestino"];
      $NroVuelo=substr($_REQUEST["nroVuelo"], -4);

      $etd->importarPax($idFileTuua,$FechaUso,$LocOrigen,$LocDestino,(int)$NroVuelo);
   }
    if($flag=="EliminarManifiesto"){
      $etd=new EnviarTuaDAO();
      $idFileTuua=$_REQUEST["idFileTuua"];
      try {
        $result = $etd->EliminarManifiesto($idFileTuua);
        if (!$result) {
          new Exception("El manifiesto no ha podido ser eliminado");
        }
      } catch (Exception $th) {
        echo json_encode(array("result"=>"Error","mensaje"=>$e,"icon"=>"error"));
      }
      echo json_encode(array("result"=>"Completado","mensaje"=>"El manifiesto ha sido eliminado.","icon"=>"success"));
    }
    if($flag=="ActualizarManifiesto"){
      
      $etd=new EnviarTuaDAO();	
      $idFileTuua=$_REQUEST["idFileTuua"];
      $hora_despegue=$_REQUEST["hora_despegue"];
      $hora_cierra_despegue=$_REQUEST["hora_cierra_despegue"];
      $hora_llegada_destino=$_REQUEST["hora_llegada_destino"];
      $matricula_avion=$_REQUEST["matricula_avion"];
      $params = array("hora_despegue"=>$hora_despegue,"hora_cierra_despegue"=>$hora_cierra_despegue,"hora_llegada_destino"=>$hora_llegada_destino,"matricula_avion"=>$matricula_avion);
      try {
        $result = $etd->ActualizarManifiesto($idFileTuua,$params);
        if (!$result) {
          new Exception("Ha ocurrido un error al actualizar el manifiesto, intentelo más tarde.");
        }
      } catch (Exception $e) {
        echo json_encode(array("result"=>"Error","mensaje"=>$e,"icon"=>"error"));
      }
      echo json_encode(array("result"=>"Completado","mensaje"=>"Ha terminado el proceso con éxito","icon"=>"success"));
    }

    //require_once("clases/EnviarTuaDAO.php");
    //require_once("clases/EnviarTuaCORPAC.php");
    //require_once("clases/EnviarTuaAAP.php");
  }
}
