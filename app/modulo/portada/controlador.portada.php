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
    
}
