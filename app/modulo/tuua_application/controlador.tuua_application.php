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
}
