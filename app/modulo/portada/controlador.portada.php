<?php
date_default_timezone_set('America/Lima');
ini_set('max_execution_time',0);
ini_set('memory_limit', '300M');
ini_set('display_errors', 'Off');
error_reporting();
class portada extends App{
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

    public function init_tuua_listado_vuelos()
    {
      $sql="SELECT *
      FROM usuario u 
      WHERE u.idusuario=".$_SESSION["ck_id_usuario_ini"];
      $resulta=func_select($sql);
      for($i=0;$i<count($resulta);$i=$i+1)
      {
        $estacion=$resulta[$i]["idEstacion"];		
      }

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
      
        
        if($_SESSION["fecVueloTip"] == ""){
              
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
    }


    public function list_modulos()
    {
      $modelo = new modeloPortada();
      $modulos = "SELECT * FROM lgs_modules WHERE state_module = 1";
      $modulos = $modelo->executeQuery( $modulos );
      $tree = $this->buildTree($modulos);
      //$treeHtml = $this->buildTreeHtml($tree);
      echo json_encode($tree);
        //return $tree;
    }
    public function buildTree($elements, $parentId = 0)
    {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }
    public function buildTreeHtml($elements, $opt="")
    {
        $branch = array();
        $li = '';
       
        foreach ($elements as $element) {
            $li = $li . (isset($element['children']) ? ('
            <v-list-group '.($opt=="childs"?' no-action sub-group ':' prepend-icon="'.$element["icon_module"].'" ').' value="true" >
            <template v-slot:activator>
              <v-list-tile>
                <v-list-tile-title>'.$element['name_module'].'</v-list-tile-title>
              </v-list-tile>
            </template> '. $this->buildTreeHtml($element['children'], 'childs').' </v-list-group>') :
                            ('<v-list-tile href="#'.$element["url_module"].'">
                            <v-list-tile-action>
                              <v-icon>' . $element["icon_module"] . '</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-title>' . $element['name_module']) .'</v-list-tile-title>
                          </v-list-tile>');
        }
        return $li;
    }
    public function is_in_array($array, $key, $key_value){
      $within_array = false;
      foreach( $array as $k=>$v ){
        if( is_array($v) ){
            $within_array = $this->is_in_array($v, $key, $key_value);
            if( $within_array ){
                break;
            }
        } else {
                if( $v == $key_value && $k == $key ){
                        $within_array = true;
                        break;
                }
        }
      }
      return $within_array;
    }
    function removeElementWithValue($array, $key, $value){
      $new_array = array();
      foreach($array as $subKey => $subArray){
          if($subArray[$key] == $value){
                unset($array[$subKey]);
          }else{
            $new_array[]=$subArray;
          }
      }
      return $new_array;
    } 
    
}
