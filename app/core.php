<?php
date_default_timezone_set('America/Lima');

unset($_SESSION['mensaje_alerta_exito']);
unset($_SESSION['mensaje_alerta_error']);
if (DESARROLLO == true) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 'Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', APP . DS . 'logs' . DS . 'error.log');
}

$acceso = TRUE;
if (REQUIERE_ACCESO) {
  //  (isset($_SESSION['usuario'])) ? $acceso = TRUE : $acceso = FALSE;
}

$id = NULL;
if(URL_AMIGABLE){
    $uri = explode('?', $_SERVER['REQUEST_URI']);
    (BASE!=='' and BASE!=='/')? $uri[0] = str_replace(BASE, '', $uri[0]) : $uri[0] = trim($uri[0], '/');
    $request = explode('/',$uri[0]);
    //$request = explode('/',(substr($uri[0],0,1)=="/"?substr($uri[0],1):$uri[0])) ;
    //ASIGANCION DEL MODULO
    (isset($request[0]) and $request[0] != '' and $acceso) ? $modulo = $request[0] : $modulo = MODULO_DEFAULT;
    //ASIGNACION DE LA ACCION
    (isset($request[1]) and $request[1] != '' and ($acceso or $modulo==MODULO_DEFAULT)) ? $accion = $request[1] : $accion = ACCION_DEFAULT;
    //ASIGNACION DE LA VARIABLE PRINCIPAL
    (isset($request[2]) and $request[2] != '' and ($acceso or $modulo==MODULO_DEFAULT)) ? $id = $request[2] : $id = NULL;
}

//ASIGANCION DEL MODULO
if(isset($_REQUEST['modulo']) and $_REQUEST['modulo'] != '' and ($acceso or $modulo==MODULO_DEFAULT)){
    $modulo = $_REQUEST['modulo'];
    //ASIGNACION DE LA ACCION
    (isset($_REQUEST['accion']) and $_REQUEST['accion'] != '' and ($acceso or $modulo==MODULO_DEFAULT)) ? $accion = $_REQUEST['accion'] : $accion = ACCION_DEFAULT;
}else{
    if(!isset($modulo)){
        $modulo = MODULO_DEFAULT;
        $accion = ACCION_DEFAULT;
    }
}

//UBICAR CONTROLADOR
if (file_exists(APP . DS . 'modulo' . DS . $modulo . DS . "controlador." . $modulo . ".php")) {
    include_once (APP . DS . 'libreria' . DS . 'funcion.php');
    require_once (APP . DS . 'core' . DS . 'app.class.php');
    require_once (APP . DS . 'core' . DS . 'utils.sql.php');
    require_once (APP . DS . 'core' . DS . 'conexion.class.php');
    require_once (APP . DS . 'core' . DS . 'conexionpasarela.class.php');
    require_once (APP . DS . 'core' . DS . 'conexionprasysperuvian.class.php');
    require_once (APP . DS . 'core' . DS . 'plantilla.class.php');
    require_once (APP . DS . 'modulo' . DS . $modulo . DS . "controlador." . $modulo . ".php");
    //UBICAR MODELO
    if (file_exists(APP . DS . 'modulo' . DS . $modulo . DS . "modelo." . $modulo . ".php")) {
        require_once (APP . DS . 'modulo' . DS . $modulo . DS . "modelo." . $modulo . ".php");
    }
    $objeto = new $modulo($modulo, $accion, $id);
    //VALIDAR MÉTODO
    if (method_exists($objeto, $accion)) {
        if (isset($_REQUEST["usuario"]) and $_REQUEST["usuario"]!="" and isset($_REQUEST["contrasena"]) and $_REQUEST["contrasena"]!="") {
            $p = new Plantilla($modulo, $accion, $id);
            $p->init_app();
        }
        $objeto->$accion();
    } else {
        ob_start();
        $msj = 'Invalid method. Please check the URL.';
        include('404.php');
        $contenido = ob_get_contents();
        ob_end_clean();
        echo $contenido;
        //include('400.shtml');
        die();
    }
} else {
    ob_start();
    $msj = 'Invalid module. Please check the URL.';
         include('404.php');
        $contenido = ob_get_contents();
        ob_end_clean();
        echo $contenido;
    die();
}
