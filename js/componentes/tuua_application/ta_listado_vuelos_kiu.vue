<template id="ta_listado_vuelos_kiu">
    <div class="" > 
       ta_listado_vuelos_kiu
       
<input name="button" type="button" class="button" id="button" value="Agregar Manifiesto" @click="CrearManifiesto()" style="margin-left: 26PX; float:left;"><br/>
<table width="846" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="button">
    <td width="63" height="21"  scope="col">Id File</td>
    <td width="160"  scope="col">Nombre Archivo</td>
    <td width="74"  scope="col">Vuelo</td>
    <td width="74"  scope="col">Fecha</td>    
    <td width="88"  scope="col">Origen</td>
    <td width="90"  scope="col"># Pax</td>
    <td width="81"  scope="col">Id Mani.</td>
    <td width="104"  scope="col">Estado</td>
    <td width="112"  scope="col">Opciones</td>
  </tr> 
       <!-- if($resulta[$i]["idFileTuua"]==$_REQUEST["idFileTuuaUno"]){-->
			 
		 
		
<!-- IdVuelo,Boleto,Cupon,FechaUso,NombrePax,Tipo,foid,Tarifa,NroVuelo,Carrier,LocOrigen,LocDestino,Clase,BaseTarifa,Promocion,Referencia,BoletoCanje,UsuarioReg -->
  <tr class="columna" v-for="(row,index) in cabeceraFile" :style="{border:msg}">
    <td height="15" align="center" bgcolor="#FFFFFF" class="columna">{{row.idFileTuua}}</td>
    <td align="center" bgcolor="#FFFFFF" class="columna">{{row.nombreArchivo}}</td>
    <td align="center" bgcolor="#FFFFFF" class="columna">{{row.nroVuelo}}</td>
    <td align="center" bgcolor="#FFFFFF" class="columna">{{row.Fecha}}</td>    
    <td align="center" bgcolor="#FFFFFF" class="columna">{{row.aeroEmbarque}}</td>
    <td align="center" bgcolor="#FFFFFF" class="columna">{{row.Pax}}</td>
    <td align="center" bgcolor="#FFFFFF" class="columna">{{row.IdManifiesto}}</td>
    <td align="left" bgcolor="#FFFFFF" class="columna">{{row.nEstado}} - {{row.Estado}}</td>
    <td bgcolor="#FFFFFF" class="columna">
      <div :id="'id_procesa_'+row.Boleto+'_'+row.Cupon">
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
          	<td v-if="row.Pax>0" width="" align="center"> <a href="javascript:void(0)" title="Importar Pax"><img src="images/import.png" > </a> </td>
            <td v-else width="" align="center"> <a  href="javascript:void(0)" @click="ImportarPax(row.idFileTuua,row.nroVuelo,row.Fecha,row.aeroEmbarque)" title="Importar Pax"><img src="images/import.png" > </a> </td>
            <!--<td width="" align="center"> <a  href="ta_detalle_vuelo_kiu.php?id=<?php echo $resulta[$i]["idFileTuua"]; ?>" title="Ver Detalle de Pax"><img src="images/pasajero.gif" > </a> </td>-->
			<td width="" align="center"> <a :href="'/intranet/app/tuua/index/'+row.idFileTuua" title="Ver Detalle de Pax"><img src="images/pasajero.gif" > </a> </td>			
            <!--<td width="" align="center"><a href="ta_sendADP.php?idTuuaFile=<?php echo $resulta[$i]["idFileTuua"]; ?>" title="Re-Procesa TUUA"><img src="img/proce.jpg" width="50" height="10" /></a></td>-->            
			<td width="" align="center"><a href="javascript:void(0)" @click="Reprocesar(row.idFileTuua,row.aeroEmbarque)" title="Re-Procesa TUUA"><img src="img/proce.jpg" width="50" height="10" /></a></td>

      <td width="" align="center"><a href="javascript:void(0)" @click="Actualizar(row.idFileTuua)" title="Actualizar"><img src="images/modificar.png" width="20" height="20"></a></td>
      <td width="" align="center"><a href="javascript:void(0)" @click="Eliminar(row.idFileTuua)" title="Eliminar"><img src="images/delete.png" width="20" height="20"></a></td>
		  </tr>   
        </table>
        
      </div>
      
    </td>
  </tr>
</table>
    </div> 
</template>
<script>
//import variable_entorno from '../../variable_entorno.js';

export default {
    name: 'ta_listado_vuelos_kiu',
    props:[''],
    components: { },
    data:()=>({
        cabeceraFile:[],
        msg:'2px solid red',
     }),
    created:function(){
     },
    mounted:function(){
        //this.init_ta_listado_vuelos_kiu();
    },
    methods:{
        init_ta_listado_vuelos_kiu(){
            var self = this;
            axios.get('init_ta_listado_vuelos_kiu?view').then(function(response){
                let data = response.data;
                console.log(data)
                self.cabeceraFile = data.data;
            });
        },
        CrearManifiesto(){

        },
        ImportarPax(){

        },
        Reprocesar(){

        },
        Actualizar(){

        },
        Eliminar(){

        }
    }
}
</script>

