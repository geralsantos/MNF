<?php
class modeloTuua_application extends MySQL{

    public function get_session($sess){
      
        $sql="select count(*) as num, idusuario, mobile from admSessionPeruvian where idsession=:idsession and estado=1";
        $sql = $this->executeQuery( $sql,array("idsession"=>$sess) );
        if ($sql) {

            //$sql="update admSessionPeruvian set estado=2 where idsession='$sess'";
            $response = $this->updateData('admSessionPeruvian', array('estado'=>2), array('idsession'=>$sess));
            //$db->execute($sql);
            //$db->close();		

            $mobile = $sql[0]["mobile"] == 0?1:0;
            return array("id"=>$sql[0]["idusuario"],"mobile"=>$mobile);		
        } else {
            return 0;
        }
    }
    function get_user($IdUsuario)
    {
        $sql="SELECT a.*, b.nombre_perfil FROM usuario a INNER JOIN usuario_perfil b ON a.id_perfil = b.id_perfil WHERE idusuario=:idusuario";
        $sql = $this->executeQuery( $sql,array("idusuario"=>$IdUsuario) );
        //$this->valores =  $db->getobj($sql);
        //$db->close();
        return array("valores"=>$sql);
    }
    public function AddSession($session, $user, $iduser, $ip, $mobile) {
         
        $activo = 1;
        $sql = $this->insertData("admSessionPeruvian",array("idsession"=>$session,"fecha_session"=>date("Y-m-d"),"horaini_session"=>date("Y-m-d H:m:00"),"horafin_session"=>date("Y-m-d H:m:00"),"idusuario"=>$iduser,"usuario"=>$user,"estado"=>$activo,"ip"=>$ip,"mobile"=>$mobile));       
        return $this->lastId();
      
    }
    public function UserLogin($user, $pass) {
        //$pass = md5($pass);
        $sql = "select idusuario from usuario where usuario=:usuario and clave=:clave and activo=1";
        $sql = $this->executeQuery( $sql,array("usuario"=>$user,"clave"=>$pass) );
        if (count($sql)) {
            return $sql[0]["idusuario"];
        }else {
            return "";
        }
    }
    public function tuua_cabecera($data=array()){
        $origen = $data["origen"];
        $fe1 = $data["fe1"];
        $fe2 = $data["fe2"];
        if( strlen($origen)>0)
        {
            $sql="SELECT c.idFileTuua, c.nombreArchivo, c.nroVuelo, c.fecVueloTip, c.aeroEmbarque, p.destinoPax, c.IdManifiesto,
            (SELECT COUNT(*) FROM tuuaPasajerosFile WHERE idFileTuua=c.idFileTuua and estado=1) Pax, e.nombre as Estado, c.Estado as nEstado,
            STR_TO_DATE(c.fecVueloTip,'%d/%m/%Y') Fecha
            FROM tuuaCabeceraFile c
            LEFT JOIN tuuaPasajerosFile p ON c.idFileTuua=p.idFileTuua
            LEFT JOIN tuuaEstados e on e.estado = c.Estado
            WHERE STR_TO_DATE(c.fecVueloTip,'%d/%m/%Y') >=:fecVueloTip AND  STR_TO_DATE(c.fecVueloTip,'%d/%m/%Y') <=:fecVueloTip2 and c.aeroEmbarque='" . $origen . "' and e.estado<>3 GROUP BY 1 ORDER BY 11, 3";
        }
        else
        {
            $sql="SELECT c.idFileTuua, c.nombreArchivo, c.nroVuelo, c.fecVueloTip, c.aeroEmbarque, p.destinoPax, c.IdManifiesto,
            (SELECT COUNT(*) FROM tuuaPasajerosFile WHERE idFileTuua=c.idFileTuua and estado=1) Pax, e.nombre as Estado, c.Estado as nEstado,
            STR_TO_DATE(c.fecVueloTip,'%d/%m/%Y') Fecha
            FROM tuuaCabeceraFile c
            LEFT JOIN tuuaPasajerosFile p ON c.idFileTuua=p.idFileTuua
            LEFT JOIN tuuaEstados e on e.estado = c.Estado
            WHERE STR_TO_DATE(c.fecVueloTip,'%d/%m/%Y') >=:fecVueloTip AND  STR_TO_DATE(c.fecVueloTip,'%d/%m/%Y') <=:fecVueloTip2 and e.estado<>3 GROUP BY 1 ORDER BY 11, 3";
        }
        $response = $this->executeQuery( $sql,array("fecVueloTip"=>$fe1,"fecVueloTip2"=>$fe2,"aeroEmbarque") );
        return $response;
    }
}
