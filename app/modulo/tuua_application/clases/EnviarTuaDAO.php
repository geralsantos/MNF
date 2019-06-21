<?php
class EnviarTuaDAO extends modeloTuua_application{
    private $inbox;
    function enviar_adp_masivo($arr_idTuuaFile=array()){
        foreach ($arr_idTuuaFile as $idTuuaFile) {
           $this->Reprocesar($idTuuaFile);
        }
        return true;
    }
    function EliminarManifiesto($idTuuaFile){
        $da = new modeloTuua_application();
        //$sql = "UPDATE tuuaCabeceraFile set Estado = 3 WHERE idFileTuua ='".$idTuuaFile."'";
        $sql = $da->updateData("tuuaCabeceraFile", array("Estado"=>3), array("idFileTuua"=>$idTuuaFile));
        if (!$sql) {
            return false;
        }
        return true;
    }
    function ActualizarManifiesto($idTuuaFile,$params=array()){
        $da = new modeloTuua_application();
        //$sql = "UPDATE tuuaCabeceraFile set horaCierrePuerta='".$params["hora_despegue"]."',horaCierreDespegue='".$params["hora_cierra_despegue"]."',horaLlegadaDestino='".$params["hora_llegada_destino"]."',matriculaAvion='".$params["matricula_avion"]."' WHERE idFileTuua=:idFileTuua";
        $values = array('horaCierrePuerta'=>$params["hora_despegue"],'horaCierreDespegue'=>$params["hora_cierra_despegue"],'horaLlegadaDestino'=>$params["hora_llegada_destino"],'matriculaAvion'=>$params["matricula_avion"],);
        $where = array('idFileTuua'=>$idTuuaFile);
        $sql = $da->updateData("tuuaCabeceraFile", $values, $where);
        if (!$sql) {
            return false;
        }
        return true;
    }
    function ConsultarManifiesto($idTuuaFile){
        $da = new Datos();
        $sql = "SELECT nroVuelo,fecVueloTip,aeroEmbarque,horaCierrePuerta,horaCierreDespegue,horaLlegadaDestino,matriculaAvion FROM tuuaCabeceraFile WHERE idFileTuua ='".$idTuuaFile."'";
        if (!$sql = $da->EjecutarDatosNuevo($sql)) {
            return false;
        }
        $arr = array();
        while ($row = $sql->fetch_assoc()) 
        {
            $fecha = explode("/",$row['fecVueloTip']);
            $dia=$fecha[0];
            $mes=$fecha[1];
            $anio=$fecha[2];
            $fecha = $anio."-".$mes."-".$dia;
            $nrovuelo = $row['nroVuelo'];
            $pattern = sprintf( '/%s/ims', preg_quote('P90', '/'));
            $nrovuelo = preg_replace($pattern,"",$nrovuelo);
            $arr = array("nroVuelo"=>$nrovuelo,"fecVueloTip"=>$fecha,"aeroEmbarque"=>$row['aeroEmbarque'],"horaCierrePuerta"=>$row['horaCierrePuerta'],"horaCierreDespegue"=>$row['horaCierreDespegue'],"horaLlegadaDestino"=>$row['horaLlegadaDestino'],"matriculaAvion"=>$row['matriculaAvion']);
        }
        $response = array("data"=>$arr);
        return json_encode($response);
    }
    function Reprocesar($idTuuaFile) {

        $da = new Datos();

        //La primera consulta me halla la cantidad de pasajeros ejm: '00051'
        $sqlcant = "SELECT LPAD(COUNT(*),5,'0') AS cantLineasDetalle FROM tuuaPasajerosFile WHERE estado = 1 AND idFileTuua = " . $idTuuaFile;
        $listacant = $da -> ListarDatos2($sqlcant);
        //inserto la cantidad de pasajeros al campo cantLineasDetalle
        $sqlcant_mod = "UPDATE tuuaCabeceraFile SET cantLineasDetalle = '" . $listacant[0]['cantLineasDetalle'] . "' WHERE idFileTuua = " . $idTuuaFile;
        $da -> EjecutarDatos($sqlcant_mod);

        $sql = "SELECT * FROM tuuaCabeceraFile WHERE idFileTuua=" . $idTuuaFile;
        $rsXML = $da -> ListarDatos2($sql);
        if (count($rsXML) > 0) {

            //$sql="UPDATE tuuaCabeceraFile SET Estado=10 WHERE idFileTuua=" . $rsXML[0]["idFileTuua"] ; // estado trancitorio del archivo
            //$da->EjecutarDatos($sql);

            for ($i = 0; $i < count($rsXML); $i = $i + 1) {
                $idFile = $rsXML[$i]["idFileTuua"];

                $fechavuelo = $rsXML[$i]["fecVueloTip"];
                $nroVuelo = $rsXML[$i]["nroVuelo"];

                $vueloOrigen = $rsXML[$i]["aeroEmbarque"];
                $nroPasajeros = $rsXML[$i]["cantLineasDetalle"];
                $horaVuelo = $rsXML[$i]["horaCierreDespegue"];
                $horaDespegue = substr($horaVuelo, 0, 2) . ":" . substr($horaVuelo, 2, 4);
                $horaCierreDespegue = $rsXML[$i]["horaCierreDespegue"];
                $idXMLFile = $rsXML[$i]["IdManifiesto"];

                $sql = "select * from tuuaPasajerosFile where idFileTuua=" . $idFile . " and estado=1";
                $rsPasajero = $da -> ListarDatos2($sql);
                $countPasajeros = count($rsPasajero);

                $xmlCuerpo = "";
                $nroPasajeros = 0;

                for ($j = 0; $j < count($rsPasajero); $j = $j + 1) {

                    $apellidoPax = $rsPasajero[$j]["apellidoPax"];
                    $nombrePax = $rsPasajero[$j]["nombrePax"];
                    $tipoPax = $rsPasajero[$j]["tipoPax"];
                    $foidPax = $rsPasajero[$j]["foidPax"];
                    $nroPaxFFrecuente = $rsPasajero[$j]["nroFrecPax"];
                    $destinoPax = $rsPasajero[$j]["destinoPax"];
                    $clasePax = $rsPasajero[$j]["clasePax"];
                    $nroTicketPax = $rsPasajero[$j]["nroTicketPax"];
                    $nroCuponPax = $rsPasajero[$j]["nroCuponPax"];
                    $nroReferenciaPax = $rsPasajero[$j]["nroReferencia"];
                    $nroAsientoPax = $rsPasajero[$j]["nroAsientoPax"];
                    $destinoPax = $rsPasajero[$j]["destinoPax"];

                    $categoriaPax = $rsPasajero[$j]["categoria_Pax"];

                    $foidPaxXML = $this -> buscaFoidADP($foidPax);
                    $valorInfante = "False";
                    if ($nroAsientoPax == "")
                        $nroAsientoPax = "0";

                    // ----------------------------VERIFICAR DIGITOS DE PASAV_BOARDING----------------------------
                    //if(strlen($nroReferenciaPax)==3) $nroReferenciaPax = substr($nroReferenciaPax,0,3);

                    $pasab_nombre = $apellidoPax . "/" . $nombrePax;

                    // -------------VERIFICAR SI SON PASAJEROS DE OTRA LINEA AERIA-------------
                    if (strlen(trim(str_replace(" ", "", $nroTicketPax))) == 0)
                        $nroTicketPax = $rsPasajero[$j]["idItensPax"];

                    if ($categoriaPax != "T") {

                        $xmlCuerpo = $xmlCuerpo . "
					  <Pax>
						 <PASAV_TICKET>" . $nroTicketPax . "</PASAV_TICKET>
						 <PASAV_NOMBRE>" . substr($pasab_nombre, 0, 48) . "</PASAV_NOMBRE>
						 <PASAV_BOARDING>" . $nroReferenciaPax . "</PASAV_BOARDING>
						 <PASAV_SITE_NUMBER>" . $nroAsientoPax . "</PASAV_SITE_NUMBER>
						 <PASAV_FOID>" . substr($foidPaxXML, 0, 19) . "</PASAV_FOID>
						 <PASAB_EMBARCADO>1</PASAB_EMBARCADO>
						 <PASAB_ESTRANSICION>0</PASAB_ESTRANSICION>
						 <PASAB_ESINFANTE>" . $tipoPax . "</PASAB_ESINFANTE>
						 <PASAB_DESTINO>" . $destinoPax . "</PASAB_DESTINO>
						 <PASAB_ESTADO>1</PASAB_ESTADO>
					  </Pax>";

                        $nroPasajeros++;
                    }
                }

                $xmlCabecera = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>
						<Manifiesto>
						<IdManifiesto>" . $idXMLFile . "</IdManifiesto>
						<Usuario>P3rUv1@n</Usuario>
						<Clave>fwTekXP1hZw=</Clave>
						<Vuelo>" . $nroVuelo . "</Vuelo>
						<Fecha>" . $fechavuelo . " " . $horaDespegue . "</Fecha>
						<Estado>1</Estado>
						<Motivo>99</Motivo>
						<Origen>" . $vueloOrigen . "</Origen>
						<Es_nacional>1</Es_nacional>
						<Pasajeros_Salida>" . $nroPasajeros . "</Pasajeros_Salida>
						<Pasajeros_Transito>0</Pasajeros_Transito>
						<ListaPax>";

                $xmlPie = "
			   </ListaPax>
			</Manifiesto>";

                $xmlFile = $xmlCabecera . $xmlCuerpo . $xmlPie;

                //echo $xmlFile;die("Fin");
                if ($_SERVER['REMOTE_ADDR'] == "172.16.1.45" || $_SERVER['REMOTE_ADDR'] == "172.16.1.43" || $_SERVER['REMOTE_ADDR'] == "172.16.1.53") {
                    echo $xmlFile;
                }
                $this -> enviaXMLADP($xmlFile, $idFile, $vueloOrigen);
                return;

            }
        }
    }
    function eliminar_correos_leidos($nro_correo_eliminar=array()){
        $inbox = $this->inbox;
        foreach ($nro_correo_eliminar as $nroMsg) 
        {
            echo "mensaje a eliminar: ".$nroMsg. "<br />\n";
            $chequeo = imap_mailboxmsginfo($inbox);
            echo "Mensajes antes de borrar: " . $chequeo->Nmsgs . "<br />\n";
            imap_delete($inbox, $nroMsg) or die('Ha fallado la imap_delete: ' . imap_last_error());
            $chequeo = imap_mailboxmsginfo($inbox);
            echo "Mensajes después de delete: " . $chequeo->Nmsgs . "<br />\n";
            imap_expunge($inbox) or die('Ha fallado la imap_expunge: ' . imap_last_error());
            $chequeo = imap_mailboxmsginfo($inbox);
            echo "Mensajes después de purgar: " . $chequeo->Nmsgs . "<br />\n";
        }
        imap_close($inbox);
    }
    function insertpasajeroprueba($idTuuaFile=array(),$grupo_boletos=array()){
        $arr_values = array();
        foreach ($grupo_boletos as $boletos) {
            foreach ($boletos as $boleto) {
                $arr_values[] ="(".$idTuuaFile["firstIdFileTuua"].",'".$boleto['apellido']."','".$boleto['nombre']."','A','00000000','','".$boleto['destino']."','".$boleto['clase']."','".$boleto['boleto']."','1','000','".$boleto['asiento']."','1')";
            }
            $idTuuaFile["firstIdFileTuua"]++;
        }

        $sql2 = "INSERT INTO tuuaPasajerosFile
        (idFileTuua,
        apellidoPax,
        nombrePax,
        tipoPax,
        foidPax,  
        nroFrecPax,
        destinoPax,
        clasePax,
        nroTicketPax,
        nroCuponPax,
        nroReferencia, 
        nroAsientoPax,
        estado)
        VALUES ". implode(",",$arr_values);
        /*if (!$da->EjecutarDatosNuevo($sql2)) {
            return false;
        }*/
        return array("sql"=>$sql2);
    }
    function existeCabeceraFile($nro_correo_eliminar,$grupo_boletos,$manifiestos){
        $da = new Datos();
        foreach (array_keys($manifiestos) as $key => $value) {
            $nuevoManifiestos[]="'".$value."'";    
        }
        if (!empty($nuevoManifiestos)) {
            echo $sql = "SELECT CONCAT(nombreArchivo,'||',aeroEmbarque,'||',(SUBSTRING_INDEX(fecVueloTip,'/',-1))) as nombreArchivo FROM tuuaCabeceraFile WHERE CONCAT(nombreArchivo,'||',aeroEmbarque,'||',(SUBSTRING_INDEX(fecVueloTip,'/',-1))) IN (".(implode(',',$nuevoManifiestos)).")";
            if (!$sql = $da->EjecutarDatosNuevo($sql)) {
                return false;
            }
            $state=false;
            $response = array("state"=>$state,"nro_correo_eliminar"=>$nro_correo_eliminar,"cabe_manifiesto"=>$manifiestos,"grupo_boletos"=>$grupo_boletos);
            /* $cabe_manifiesto = array();
            $grupo_boletos = array();
            $nro_correo_eliminar = array();*/
            //echo "<pre>".print_r($response,true)."</pre>";
            while($row = $sql->fetch_assoc()) {
                $keyManifiesto=array_keys($manifiestos);
                if (in_array($row["nombreArchivo"],$keyManifiesto)) {
                    unset($nro_correo_eliminar[$row["nombreArchivo"]]);
                    unset($manifiestos[$row["nombreArchivo"]]);
                    unset($grupo_boletos[$row["nombreArchivo"]]);
                    $state=true;
                    echo "nombre de archivo que ya existen : ".$row["nombreArchivo"]." <br>\n";
                }
            }
            if ($state) {
                $response = array("state"=>$state,"nro_correo_eliminar"=>$nro_correo_eliminar,"cabe_manifiesto"=>$manifiestos,"grupo_boletos"=>$grupo_boletos);
            }
        }
        return $response;
    }
    function insertarCabecera($fecha_vuelo, $nro_vuelo, $origen, $hora_despegue, $hora_cierra_despegue, $hora_llegada_destino, $matricula_avion, $wsCorreos=array()) {
        $da = new modeloTuua_application();
        if (empty($wsCorreos)) {
            if (strlen($nro_vuelo) == 3) {
                $nro_vuelo = "P90" . $nro_vuelo;
            } else {
                $nro_vuelo = "P9" . $nro_vuelo;
            }
    
            //mktime(hora,minuto,segundoi,mes,dia,anio);
            $mes1 = explode("-", $fecha_vuelo);
            $mes = $mes1[1];
    
            $date_fly = $mes1[2] . $this -> verMesPago($mes);
            $fecha_vuelo = date("d/m/Y", strtotime($fecha_vuelo));
            $fecha_corta = substr($fecha_vuelo, 3, 2) . substr($fecha_vuelo, 0, 2);
    
            $nombreArchivo = 'temp/' . $nro_vuelo . $fecha_corta;
            //geral

            $id_manifiesto = $this -> ObtenerIDManifiesto();

            /*$sql = "INSERT INTO tuuaCabeceraFile (nombreArchivo,nroVuelo,fecVueloTip,fechaVuelo,aeroEmbarque,horaCierrePuerta,horaCierreDespegue,horaLlegadaDestino,matriculaAvion,Estado,IdManifiesto) VALUES 
                ('$nombreArchivo','$nro_vuelo','$fecha_vuelo','$date_fly','$origen','$hora_despegue','$hora_cierra_despegue','$hora_llegada_destino','$matricula_avion',2,$id_manifiesto)";*/
            //echo $sql."\n";
            //return;
            $id_manifiesto = $id_manifiesto + 1;
            $values = array("nombreArchivo"=>$nombreArchivo,"nroVuelo"=>$nro_vuelo,"fecVueloTip"=>$fecha_vuelo,"fechaVuelo"=>$date_fly,"aeroEmbarque"=>$origen,"horaCierrePuerta"=>$hora_despegue,"horaCierreDespegue"=>$hora_cierra_despegue,"horaLlegadaDestino"=>$hora_llegada_destino,"matriculaAvion"=>$matricula_avion,"Estado"=>2,"IdManifiesto"=>$id_manifiesto);
            $sql = $this->insertData("tuuaCabeceraFile",$values);

            //$da -> EjecutarDatos($sql);
            $updateManifiesto = $this->ActualizarIDManifiesto($id_manifiesto);
            
            return $sql;
        }else {
            $id_manifiesto = $this -> ObtenerIDManifiesto();
            
            foreach ($wsCorreos as $key => $value) {
                $id_manifiesto = $id_manifiesto + 1;
                $nro_vuelo = $value["nro_vuelo"];
                if (strlen($nro_vuelo) == 3) {
                    $nro_vuelo = "P90" . $nro_vuelo;
                } else {
                    $nro_vuelo = "P9" . $nro_vuelo;
                }
                $fecha_vuelo = $value["fecha_vuelo"];
        
                //mktime(hora,minuto,segundoi,mes,dia,anio);
                $mes1 = explode("-", $fecha_vuelo);
                $mes = $mes1[1];
        
                $date_fly = $mes1[0] . $this -> verMesPago($mes);
                $fecha_vuelo = date("d/m/Y", strtotime($fecha_vuelo));
                $fecha_corta = substr($fecha_vuelo, 3, 2) . substr($fecha_vuelo, 0, 2);
        
                $nombreArchivo = 'temp/' . $nro_vuelo . $fecha_corta;
                $origen = $value["origen"];
                $hora_despegue =$value['hora_despegue'] ;
                $hora_cierra_despegue =$value['hora_cierra_despegue'] ;
                $hora_llegada_destino =$value['hora_llegada_destino'] ;
                $valoresInsert[]="('$nombreArchivo','$nro_vuelo','$fecha_vuelo','$date_fly','$origen','$hora_despegue','$hora_cierra_despegue','$hora_llegada_destino','$matricula_avion',0,$id_manifiesto)";

            }
            //$sql = "INSERT INTO tuuaCabeceraFile (nombreArchivo,nroVuelo,fecVueloTip,fechaVuelo,aeroEmbarque,horaCierrePuerta,horaCierreDespegue,horaLlegadaDestino,matriculaAvion,Estado,IdManifiesto) VALUES ".implode(",",$valoresInsert);
            $sql = $da->insertDataMasivo('tuuaCabeceraFile',array('nombreArchivo','nroVuelo','fecVueloTip','fechaVuelo','aeroEmbarque','horaCierrePuerta','horaCierreDespegue','horaLlegadaDestino','matriculaAvion','Estado','IdManifiesto'), $valoresInsert);
            if (!$da) {
                return false;
            }
            $firstIdFileTuua = $da->lastId();
            $arrIdFileTuua = array("firstIdFileTuua"=>$firstIdFileTuua,"lastIdFileFuua"=>(count($valoresInsert)+$firstIdFileTuua ) );
            $this->ActualizarIDManifiesto($id_manifiesto);
            return array("arrIdFileTuua"=>$arrIdFileTuua,"sql"=>$sql);
        }
    }

    function importarPax($idFileTuua, $FechaUso, $LocOrigen, $LocDestino, $NroVuelo) {

        require_once ("../lib/sql_clase.php");
        $oMsSql = new clsDataSql();
        $oMsSql -> conectar();

        //if($_SERVER['REMOTE_ADDR']=="172.16.1.43" and $LocOrigen = 'PIU' ){
        //if($_SERVER['REMOTE_ADDR']=="172.16.1.43"){
        //    $FechaUsoArray = explode("-", $FechaUso);
        //    $FechaUso = $FechaUsoArray[2]."".$FechaUsoArray[1]."".substr($FechaUsoArray[0],-2);
        //    $sql = "select
        //                '1' AS TipoPax,
        //                PassengerName AS NombrePax,
        //                '' AS foid,
        //                UsageOriginCode AS LocDestino,
        //                UsedClassOfService AS Clase,
        //                AirlineCode + '' + TicketNumber AS BoletoVta,
        //                CouponNumber AS Cupon
        //                    from [dbo].[FLT1A_Cupon]
        //                    where
        //                        UsageDate = '".$FechaUso."' AND
        //                        UsageType = 'F' AND
        //                        UsageFlightNumber = '00".$NroVuelo."' AND
        //                        UsageOriginCode = '".$LocOrigen."'";
        //} else {
        //$sql = "select a.*, b.foid from Usos a
        //            left join VentasBoletos b on a.BoletoVta = b.Boleto
        //            where FechaUso = '".$FechaUso."' and LocOrigen='".$LocOrigen."'
        //            and NroVuelo = '".$NroVuelo."' and TipoUso = 'VO'";

        $sql = "select IdVuelo 
				from Vuelos where 
				FechaVuelo = '" . $FechaUso . "' and LocOrigen='" . $LocOrigen . "'  
				and NroVuelo = '" . $NroVuelo . "' ";

        error_log($sql);

        $rp = $oMsSql -> execute($sql);
        $IdVuelo = array();
        
        while ($res = mssql_fetch_array($rp)) {
            $IdVuelo[] = $res["IdVuelo"] ;
        }

        $sql = "select a.BoletoVta, A.Cupon, c.Clase, b.foid, a.NombrePax AS NombrePax, a.TipoPax, a.LocDestino
				from Usos a
				left join VentasBoletos b on a.BoletoVta = b.Boleto 
				left join VentasSegmentos c on c.Boleto = a.BoletoVta and c.Cupon = a.Cupon
				where IdVuelo in (" . implode(',',$IdVuelo) . ") and TipoUso = 'VO'
				union all
				select a.BoletoVta, A.Cupon, a.Clase, '' foid, a.NombrePax, a.TipoPax, a.LocDestino
				from Interlineas a
				where a.IdVuelo IN (" . implode(',',$IdVuelo) . ") and Source = '01'";

        error_log($sql);
        //}

        $rp = $oMsSql -> execute($sql);

        $da = new Datos();
        $j = 1;

        $sql2 = "delete from tuuaPasajerosFile WHERE idFileTuua=" . $idFileTuua;
        $da -> EjecutarDatos($sql2);

        while ($res = mssql_fetch_array($rp)) {

            $refer = str_pad($j, 3, "0", STR_PAD_LEFT);
            $nombre = explode("/", $res["NombrePax"]);

            switch ($res["TipoPax"]) {
                case 1 :
                    $tipoPax = "A";
                    break;
                case 2 :
                    $tipoPax = "C";
                    break;
                case 3 :
                    $tipoPax = "I";
                    break;
            }

            $sql2 = "INSERT INTO tuuaPasajerosFile
		            (idFileTuua,
		             apellidoPax,
		             nombrePax,
		             tipoPax,
		             foidPax,  
		             nroFrecPax,
		             destinoPax,
		             clasePax,
		             nroTicketPax,
		             nroCuponPax,
		             nroReferencia, 
		             nroAsientoPax,
		             estado)
			VALUES ('" . $idFileTuua . "',
			        '" . $nombre[0] . "',
			        '" . $nombre[1] . "',
			        '" . $tipoPax . "',
			        '" . $res["foid"] . "', 
			        '',        
			        '" . $res["LocDestino"] . "',
			        '" . $res["Clase"] . "',
			        '" . $res["BoletoVta"] . "',
			        '" . $res["Cupon"] . "',
			        '" . $refer . "',
			        '', 
			        '1');";
            $da -> EjecutarDatos($sql2);
            $j++;

        }
/**/
        // $sql1 = "select * from Interlineas 
// where FechaUso = '" . $FechaUso . "' and LocOrigen='" . $LocOrigen . "' 
// and NroVuelo = '" . $NroVuelo . "' and TipoUso = 'VO'";
// 
        // $rp1 = $oMsSql -> execute($sql1);
// 
        // $da = new Datos();
        // $y = $j;

        // if (count($rp1) > 0) {
// 
            // while ($res1 = mssql_fetch_array($rp1)) {
// 
                // $refer1 = str_pad($y, 3, "0", STR_PAD_LEFT);
                // $nombre1 = explode("/", $res1["NombrePax"]);
// 
                // switch ($res1["TipoPax"]) {
                    // case 1 :
                        // $tipoPax1 = "A";
                        // break;
                    // case 2 :
                        // $tipoPax1 = "C";
                        // break;
                    // case 3 :
                        // $tipoPax1 = "I";
                        // break;
                // }
// 
                // $sql3 = "INSERT INTO tuuaPasajerosFile
		            // (idFileTuua,
		             // apellidoPax,
		             // nombrePax,
		             // tipoPax,
		             // foidPax,  
		             // nroFrecPax,            
		             // destinoPax,
		             // clasePax,
		             // nroTicketPax,
		             // nroCuponPax,
		             // nroReferencia, 
		             // nroAsientoPax,        
		             // estado)
			// VALUES ('" . $idFileTuua . "',
			        // '" . $nombre1[0] . "',
			        // '" . $nombre1[1] . "',
			        // '" . $tipoPax1 . "',
			        // '" . $res1["foid"] . "', 
			        // '',        
			        // '" . $res1["LocDestino"] . "',
			        // '" . $res1["Clase"] . "',
			        // '" . $res1["BoletoVta"] . "',
			        // '" . $res1["Cupon"] . "',
			        // '" . $refer1 . "',
			        // '', 
			        // '1');";
                // $da -> EjecutarDatos($sql3);
                // $y++;
// 
            // }
// 
            // $refer2 = str_pad($y - 1, 5, "0", STR_PAD_LEFT);
// 
        // } else {
// 
            // $refer2 = str_pad($y, 5, "0", STR_PAD_LEFT);
        // }

        $sql3 = "UPDATE tuuaCabeceraFile
			SET cantLineasDetalle = '" . $j . "' 
			WHERE idFileTuua = '" . $idFileTuua . "';";
        $da -> EjecutarDatos($sql3);

        $msg = "El Sistema registro " . $j . " Pax";
        echo $msg;
        return;
    }
    
    function verMesPago($mes) {

        $month = array('01' => 'JAN', '02' => "FEB", '03' => "MAR", '04' => "APR", '05' => "MAY", '06' => "JUN", '07' => "JUL", '08' => "AUG", '09' => "SEP", '10' => "OCT", '11' => "NOV", '12' => "DEC");
        $valorMes = $month[$mes];
        return $valorMes;

    }
    
    function ActualizarIDManifiesto($id_manifiesto) {

        $da = new modeloTuua_application();
        //$sql = "UPDATE  tuuaAutogen set valor=$id_manifiesto WHERE tabla=:tabla";
        $da->updateData("tuuaAutogen", array("valor"=>$id_manifiesto), array("tabla"=>'ManiADP'));
        //$da -> EjecutarDatos($sql);
        return;

    }

    function ObtenerIDManifiesto() {
        $da = new modeloTuua_application();
        $sql = "SELECT * FROM `tuuaAutogen` WHERE tabla=:tabla";
        $listado = $da->executeQuery( $sql,array("tabla"=>'ManiADP'));
        $id_manifiesto_temp = $listado[0]["valor"];
        return $id_manifiesto_temp;

    }

    function buscaFoidADP($foid_pasa) {

        $foid_pasa = trim($foid_pasa);

        if (strlen($foid_pasa) == 2) {

            if ($foid_pasa == "PP") {
                $foid = "PP:00000000";
            } else {
                $foid = "DN:00000000";
            }

        } else if ($foid_pasa == "") {

            $foid = "DN:00000000";

        } else {

            $longitud = strlen($foid_pasa);
            $tipo_foid = substr($foid_pasa, 0, 2);

            if ($tipo_foid == "NI") {

                $numero_foid = substr($foid_pasa, 2, $longitud);
                $foid = "DN:" . $numero_foid;

            } else if ($tipo_foid == "PP") {

                $numero_foid = substr($foid_pasa, 2, $longitud);
                $foid = "PP:" . $numero_foid;

            } else {
                $numero_foid = substr($foid_pasa, 2, $longitud);
                $foid = "DN:" . $numero_foid;
            }

        }

        return $foid;

    }

    function func_destinosEmail() {
        $da = new Datos();
        $sql = "SELECT * FROM db_pasarela.parametro WHERE parametro='email_rep_ventas_pais'";
        $rs = $da -> ListarDatos2($sql);
        $emailEnvio = $rs[0]["valor"];
        return $emailEnvio;
    }

    function func_destinosEmail_Embarque($embarque) {

        switch ($embarque) {
            case "IQT" :
                $emailEmbarque = "email_tuua_iqt";
                break;
            case "TPP" :
                $emailEmbarque = "email_tuua_tpp";
                break;
            case "PIU" :
                $emailEmbarque = "email_tuua_piu";
                break;
            case "PCL" :
                $emailEmbarque = "email_tuua_pcl";
                break;
            default :
                $emailEmbarque = "email_rep_ventas_pais";
        }

        $dap = new DatosPasarela();

        $sql = "SELECT * FROM parametro WHERE parametro='" . $emailEmbarque . "'";

        $rs = $dap -> ListarDatos2Pasarela($sql);
        //$rs=func_select($sql);
        $emailEnvio = $rs[0]["valor"];

        return $emailEnvio;
    }

    function func_Graba_Log($nomArchivo, $estProceso, $vuelo, $fecha, $totalPax, $obs, $id_file) {// update insert delete
        $da = new Datos();
        $obss = preg_replace('[\s+]', '', $obs);
        $sql = "INSERT INTO tuuaLogFile (nombreArchivo,estadoProceso,nroVuelo,fechaVuelo,totalPax,obs,id_file) 
		VALUES( '" . $nomArchivo . "','" . $estProceso . "','" . $vuelo . "','" . $fecha . "','" . $totalPax . "','" . $obss . "','" . $id_file . "')";

        $da -> EjecutarDatos($sql);
        return;
    }

    function func_ErrorEmailDetalle($nomArchivo, $estProceso, $vuelo, $fecha, $totalPax, $obs) {

        require_once ('mail/htmlMimeMail5.php');
        $mail = new htmlMimeMail5();

        $ws_Aeropuerto = "ADP ";
        if (strpos($nomArchivo, "CUZ") > 0)
            $ws_Aeropuerto = "Corpac ";

        $mail -> setFrom('<tuua@peruvian.pe>');
        $mail -> setSMTPParams('mail.peruvian.pe', 25, 'mail.peruvian.pe', false, 'ventasweb@peruvian.pe', 'ven8065x');
        $mail -> setSubject($ws_Aeropuerto . 'ERROR - EXTRACCION DE PASAJEROS');
        $mail -> setPriority('high');
        //$mail->setText('Sample text');
        $body = file_get_contents('../clases/msn_error_file.html');
        $body = str_replace('--Titulo--', "Error Procesando Archivo", $body);
        $body = str_replace('--Mensaje--', "Archivo :" . $nomArchivo . "<br>Estado :" . $estProceso . "<br>Vuelo" . $vuelo . "<br>Fecha :" . $fecha . "<br>Total :" . $totalPax . "<br><b><font color='#0000CC'> Observacion :" . $obs . "</font></b>", $body);

        $mail -> setHTML($body);

        $mail -> setReceipt('ventasweb@peruvian.pe');
        $mail -> addEmbeddedImage(new fileEmbeddedImage('../clases/fondo_web.jpg'));
        $embarque = substr($nomArchivo, -3);
        $email_destinos = split(",", $this -> func_destinosEmail_Embarque($embarque));

        $result = $mail -> send($email_destinos, 'smtp');

        if ($result) {
            //guarda BD
        }
    }

    function func_EmailXMLCOMPLETC($nomArchivo, $vuelo, $fecha, $rptWS, $horacierrepuerta, $horaCierreDespegue) {

        require_once ('mail/htmlMimeMail5.php');
        $mail = new htmlMimeMail5();

        $mail -> setFrom('<tuua@peruvian.pe>');
        $mail -> setSMTPParams('mail.peruvian.pe', 25, 'mail.peruvian.pe', false, 'ventasweb@peruvian.pe', 'ven8065x');

        $ws_Aeropuerto = "ADP ";
        if (strpos($nomArchivo, "CUZ") > 0)
            $ws_Aeropuerto = "Corpac ";
        if (strpos($nomArchivo, "AQP") > 0 || strpos($nomArchivo, "TCQ") > 0)
            $ws_Aeropuerto = "AAP ";

        $mail -> setSubject($ws_Aeropuerto . 'Envio XML Completado Vuelo: ' . $vuelo . ' .:::. ' . $fecha);
        $mail -> setPriority('high');
        //$mail->setText('Sample text');
        $body = file_get_contents('../clases/msn_error_file.html');
        $body = str_replace('--Titulo--', 'Envio XML Completado Vuelo : ' . $vuelo . ' .:::. ' . $fecha, $body);

        $msgHtml = "<table width=450 border=0 cellspacing=0 cellpadding=0><tr><td width=160>Nombre Archivo</td><td width=10>:</td><td width=286>" . $nomArchivo . "</td></tr><tr><td>Nro Vuelo</td><td>:</td><td>" . $vuelo . "</td></tr><tr><td>Fecha Vuelo</td><td>:</td><td>" . $fecha . "</td></tr><tr><td>Hora Cierre Puerta</td><td>&nbsp;</td><td>" . $horacierrepuerta . "</td></tr><tr><td>Hora Cierre Despegue</td><td>&nbsp;</td><td>" . $horaCierreDespegue . "</td></tr><tr><td>Respuesta WS</td><td>:</td><td>" . $rptWS . "</td></tr></table>";
        $body = str_replace('--Mensaje--', $msgHtml, $body);

        $mail -> setHTML($body);

        $mail -> setReceipt('ventasweb@peruvian.pe');
        $mail -> addEmbeddedImage(new fileEmbeddedImage('../clases/fondo_web.jpg'));

        $embarque = substr($nomArchivo, -3);

        $email_destinos = split(",", $this -> func_destinosEmail_Embarque($embarque));

        $result = $mail -> send($email_destinos, 'smtp');

        if ($result) {
            //guarda BD
        }
    }

    function enviaXMLADP($xml, $idFileTuuacabecera, $origen) {
        try {

            //echo $xml;
            //echo "<br><h1>================= SEPARADOR ============</h1>";
            //die("Fin");
            set_time_limit(60);
            require_once ('lib/nusoap.php');
            $da = new Datos();

            $sql = "select * from tuuaCabeceraFile where idFileTuua=$idFileTuuacabecera";
            //echo $sql . "<br>";
            $rsError = $da -> ListarDatos2($sql);

            $nombreArchivo = $rsError[0]["nombreArchivo"] . $rsError[0]["aeroEmbarque"];
            $nroVuelo = $rsError[0]["nroVuelo"];
            $fechavuelo = $rsError[0]["fecVueloTip"];
            $cantidadLineasDetallan = $rsError[0]["cantLineasDetalle"];

            $horacierrepuerta = $rsError[0]["horaCierrePuerta"];
            $horaCierreDespegue = $rsError[0]["horaCierreDespegue"];

            // -----------------------------------------------------------------------------------------------------
            // -----------------------------------------------------------------------------------------------------
            // ************* AMBIENTE DE TEST *************

            /*$valorEnvioTestProd="AMBIENTE DE TEST";
             //echo $valorEnvioTestProd . "<br>";
             $oSoapClient = new nusoap_client("http://190.41.107.180/service.asmx?WSDL", "WSDL");*/

            // ************* AMBIENTE DE PRODUCCION *************
            $valorEnvioTestProd = "AMBIENTE DE PRODUCCION ADP";
            //echo $valorEnvioTestProd . "<br>";
            //$oSoapClient = new nusoap_client('http://www.adp.com.pe:8090/TUUA/Service.asmx?WSDL', "WSDL");
            //$oSoapClient = new nusoap_client('http://143.137.146.152:8090/tuua/service.asmx?WSDL', "WSDL");
            $oSoapClient = new nusoap_client('https://tuua.adp.com.pe/TUUA/service.asmx?WSDL', "WSDL");

            // -----------------------------------------------------------------------------------------------------
            // -----------------------------------------------------------------------------------------------------

            if ($sError = $oSoapClient -> getError()) {
                echo "No se pudo realizar la operaciÃ³n [" . $sError . "]";
                $sql = "UPDATE tuuaCabeceraFile SET Estado=6 WHERE idFileTuua=$idFileTuuacabecera";
                $da -> EjecutarDatos($sql);

                $this -> func_Graba_Log($nombreArchivo, "5", $nroVuelo, $fechavuelo, $cantidadLineasDetallan, $valorEnvioTestProd . "<br>" . $sError, $idFileTuuacabecera);
                $this -> func_ErrorEmailDetalle($nombreArchivo, "5", $nroVuelo, $fechavuelo, $cantidadLineasDetallan, $valorEnvioTestProd . "<br>" . $sError);

                return;
            }

            $this -> func_Graba_Log($nombreArchivo, "2", $nroVuelo, $fechavuelo, $cantidadLineasDetallan, "Generando XML : <br>" . $valorEnvioTestProd . "<br>" . $xml, $idFileTuuacabecera);

            $respuesta = $oSoapClient -> call("EnvioManifiesto", array("binXML" => base64_encode($xml)));
            $this -> func_Graba_Log($nombreArchivo, "3", $nroVuelo, $fechavuelo, $cantidadLineasDetallan, "Enviando a webservices<br>" . $valorEnvioTestProd, $idFileTuuacabecera);

            if ($_SERVER['REMOTE_ADDR'] == "172.16.1.43" || $_SERVER['REMOTE_ADDR'] == "172.16.1.53") {
                echo("<pre>" . print_r(htmlspecialchars($oSoapClient, ENT_QUOTES), true) . "</pre>");
            }

            if ($oSoapClient -> fault) {// Si
                echo "Error fault : " . $oSoapClient -> fault;
                $sql = "UPDATE tuuaCabeceraFile SET Estado=6 WHERE idFileTuua=$idFileTuuacabecera";

                $da -> EjecutarDatos($sql);

                $this -> func_Graba_Log($nombreArchivo, "5", $nroVuelo, $fechavuelo, $cantidadLineasDetallan, $valorEnvioTestProd . "<br><br>" . $sError, $idFileTuuacabecera);
                $this -> func_ErrorEmailDetalle($nombreArchivo, "5", $nroVuelo, $fechavuelo, $cantidadLineasDetallan, $valorEnvioTestProd . "<br><br>Error oSoapClient->fault" . $oSoapClient -> fault);

                return;
            } else {// No
                $sError = $oSoapClient -> getError();
                // Hay algun error ?
                if ($sError) {// Si
                    echo "Error  GetError :" . $oSoapClient -> getError() . "<BR>";
                    $sql = "UPDATE tuuaCabeceraFile SET Estado=6 WHERE idFileTuua=$idFileTuuacabecera";
                    $da -> EjecutarDatos($sql);
                    $this -> func_Graba_Log($nombreArchivo, "5", $nroVuelo, $fechavuelo, $cantidadLineasDetallan, $valorEnvioTestProd . "<br><br>" . $sError, $idFileTuuacabecera);
                    $this -> func_ErrorEmailDetalle($nombreArchivo, "5", $nroVuelo, $fechavuelo, $cantidadLineasDetallan, $valorEnvioTestProd . "<br><br>" . $sError);

                    return;
                }
            }

            if (isset($respuesta["EnvioManifiestoResult"])) {
                print_r($respuesta["EnvioManifiestoResult"]);
                echo "<br><br>";
                 echo $nroVuelo . " - " . $fechavuelo;
                 echo "<br><br>";

                $valor_rpta = print_r($respuesta, true);

                $sql = "UPDATE tuuaCabeceraFile SET Estado=2 WHERE idFileTuua=$idFileTuuacabecera";
                $da -> ListarDatos2($sql);
                $this -> func_Graba_Log($nombreArchivo, "4", $nroVuelo, $fechavuelo, $cantidadLineasDetallan, $valorEnvioTestProd . "<br>" . $valor_rpta, $idFileTuuacabecera);
                $this -> func_EmailXMLCOMPLETC($nombreArchivo, $nroVuelo, $fechavuelo, $valorEnvioTestProd . "<br>" . $valor_rpta, $horacierrepuerta, $horaCierreDespegue);

            } else {
                $valor_rpta = print_r($respuesta, true);

                echo '<br><font color=#990000>Error No se envio el manifiesto</font><br><br>';
                /*echo '<pre>';
                 print_r($respuesta);
                 echo  '</pre>';*/

                $sql = "UPDATE tuuaCabeceraFile SET Estado=6 WHERE idFileTuua=$idFileTuuacabecera";
                $da -> EjecutarDatos($sql);
                $this -> func_Graba_Log($nombreArchivo, "5", $nroVuelo, $fechavuelo, $cantidadLineasDetallan, $valorEnvioTestProd . "<br><br>" . $valor_rpta, $idFileTuuacabecera);
                $this -> func_ErrorEmailDetalle($nombreArchivo, "5", $nroVuelo, $fechavuelo, $cantidadLineasDetallan, $valorEnvioTestProd . "<br><br>" . $valor_rpta);

                return;
            }
        } catch (Exception $x) {

            echo $x;

        }

    }
    
    function ObtenerInfoCorreoVueloCheckIn($flag){
        $server = "mail01.peruvian.pe";
        $username = "altea.manifiesto@peruvian.pe";
        $password = "altea123x*"; //contraseña
        $mailbox="{".$server.":995/pop3/ssl/novalidate-cert}INBOX";
        $inbox = imap_open($mailbox, $username, $password) or die('Ha fallado la conexión: ' . imap_last_error());
        $fecha = "01 ".date('M')." ".date('Y');
        $emails = array_reverse(imap_search($inbox,'SUBJECT "P9" SINCE "'.$fecha.'" ',SE_UID)); 
        $salida="";
        $grupo_boletos=array();
        $cabe_manifiesto=array();
        $manifiesto=array();
        //promedio de 50 boletos/correos al día
        foreach($emails as $email_number) 
        {
            $overview = json_decode(json_encode(imap_fetch_overview($inbox,$email_number,0)),true);
            $subject = (string)utf8_encode(imap_qprint(iconv_mime_decode($overview[0]["subject"],0,"ISO-8859-1")));

            if (!preg_match('/( PSM)|( PTM)|( TPM)/',$subject ,$result)) 
            {            
                //if (count(explode("/",$subject))==5 && $overview[0]["from"]=="altea.manifiesto@peruvian.pe") 
                if (count(explode("/",$subject))==5) 
                {
                    $fecha = explode("/",$subject);
                    $fecha=$fecha[1];
                    $manifiesto["fecha_vuelo"] = substr($fecha,6,2)."-".substr($fecha,4,2)."-".substr($fecha,0,4);
                    $vuelo = explode("/",$subject);
                    $manifiesto["nro_vuelo"] = substr($vuelo[0],2,3);
                    $origen = explode("/",$subject);
                    $origen = explode(" ",$origen[2]); 
                    $manifiesto["origen"] = $origen[0];
                   
                    $manifiesto["hora_despegue"] ="2005";
                    $manifiesto["hora_cierra_despegue"] ="2005";
                    $manifiesto["hora_llegada_destino"] ="2105";
                    $manifiesto["matricula_avion"] ="";
                    //definiendo un identificador para luego validar si existe en la bd
                    $nro_vuelo = $manifiesto["nro_vuelo"];
                    if (strlen($nro_vuelo) == 3) {
                        $nro_vuelo = "P90" . $nro_vuelo;
                    } else {
                        $nro_vuelo = "P9" . $nro_vuelo;
                    }
                    $fecha_vuelo =  $manifiesto["fecha_vuelo"];
                    $fecha_corta = substr($fecha_vuelo, 3, 2) . substr($fecha_vuelo, 0, 2);
                    $nombreArchivo = 'temp/' . $nro_vuelo . $fecha_corta."||".$manifiesto["origen"]."||".substr($fecha,0,4);
                    //fin definiendo un identificador para luego validar si existe en la bd//
                    $cabe_manifiesto[$nombreArchivo]=$manifiesto;

                    $boletos=array();
                    $i=1;
                    $text =(string) utf8_encode(imap_fetchbody($inbox,$email_number,1));
                    $start = " $i.";
                    $end = " ".(1+$i).".";
                    $pattern = sprintf(
                    '/%s(.+?)%s/ims',
                    preg_quote($start, '/'), preg_quote($end, '/')
                    );
                    $isTicket = preg_match($pattern, ($text),$result);
                    if ($isTicket) {
                        $nro_correo_eliminar[$nombreArchivo]=$email_number;
                    }
                    $totalTickets = preg_match('/ TOTAL (.*)P9/ims',$text,$restotalTickets);
                     
                    while ($isTicket) {
                        if ((!$totalTickets?false:($restotalTickets[1]==$i))) {
                            $start = "".($i).".";
                            $pattern = sprintf( '/%s(.*)/ims', preg_quote($start, '/') );
                            $i++;
                        }else {
                            $start = "".($i).".";
                            $end = "".(++$i).".";
                            $pattern = sprintf( '/%s(.+?)%s/ims', preg_quote($start, '/'), preg_quote($end, '/') );
                        }
                        if ($isTicket = preg_match($pattern, ($text),$lineTicket)) {
                            $result = implode(' ', array_reverse(explode(' ', $lineTicket[1])));
                            $result = explode(' ',$result);
                            $result= array_values(array_filter(array_map('trim',$result),'strlen') );

                            if (preg_match('/[0-9]{13}/', $lineTicket[1])) {
                                foreach ($result as $key => $val) {
                                    if (preg_match('/^[0-9]{13}$/', $val)) {
                                        break;
                                    }else{
                                        unset($result[$key]);
                                    }
                                }
                                $result = array_values($result);
                            }

                            $indice = 0;
                            
                            $boleto = preg_match('/^[0-9]{13}$/', $result[$indice]) ? $result[$indice++] : "";
                            $orden_chk_in = preg_match('/^[0-9]{3}$/', $result[$indice]) ? $result[$indice++] : "";
                            $asiento = preg_match('/^[0-9]{3}[A-Z]{1}$/', $result[$indice]) ? $result[$indice++] : "";
                            $borded = preg_match('/^[A-Z]{1}$/', $result[$indice]) ? $result[$indice++] : "";
                            $clase = preg_match('/^[A-Z]{2}$/', $result[$indice]) ? $result[$indice++] : "";
                            $destino = preg_match('/^[A-Z]{3}$/', $result[$indice]) ? $result[$indice++] : "";
                            $origen = preg_match('/^[A-Z]{3}$/', $result[$indice]) ? $result[$indice++] : "";
                            
                            if ($manifiesto["origen"]!=$origen) {
                                //omitiendo los boletos que tienen origen distinto al del correo.
                                continue;
                            }

                            $unknown = preg_match('/^[A-Z]{1}$/', $result[$indice]) ? $result[$indice++] : "";
                            $pax = array();
                            foreach ($result as $key => $value) {
                                if ($key>=$indice) {
                                    $pax[]=$value;
                                }
                            }
                            $pax = implode(' ',array_reverse($pax));
                            $apellido = explode('/',$pax);
                            $apellido = $apellido[0];
                            $nombre = explode('/',$pax);
                            $nombre = $nombre[1];
                            $boletos[]=array("nombre"=>$nombre,"apellido"=>$apellido,"unknown"=>$unknown,"origen"=>$origen,"destino"=>$destino,"clase"=>$clase,"borded"=>$borded,"asiento"=>$asiento,"orden_chk_in"=>$orden_chk_in,"boleto"=>$boleto);
                        }
                    }

                    if (!empty($boletos)) {
                        $grupo_boletos[$nombreArchivo]=$boletos;
                    }
                }
            }
        }
        $this->inbox = $inbox;
        //echo "<pre>".print_r($grupo_boletos,true)."</pre>";
        //eliminando boletos ya existentes
        $manifiestosPurge = $this->existeCabeceraFile($nro_correo_eliminar,$grupo_boletos,$cabe_manifiesto);
        //print_r($manifiestosPurge);
        $response = array("nroCorreosEliminar"=>$nro_correo_eliminar,"cabecera"=>$cabe_manifiesto,"grupo_boletos"=>$grupo_boletos);
        if ($manifiestosPurge["state"]) {
            echo "hay manifiestos existentes en la bd, se ha eliminado los que coinciden <br>\n";
            /*if (!empty($manifiestosPurge["cabe_manifiesto"])) {
                echo "Estos son los que van a ser insertados: <br>\n";
                echo "<pre>".print_r($manifiestosPurge,true)."</pre>";
            }*/
            $cabe_manifiesto = $manifiestosPurge["cabe_manifiesto"];
            $grupo_boletos = $manifiestosPurge["grupo_boletos"];
            $nro_correo_eliminar = $manifiestosPurge["nro_correo_eliminar"];
            $response = array("nroCorreosEliminar"=>$nro_correo_eliminar,"cabecera"=>$cabe_manifiesto,"grupo_boletos"=>$grupo_boletos);
            //echo "<pre>".print_r($response,true)."</pre>";
        }
        return $response;
    }
}
?>