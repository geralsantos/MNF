<template id="ta_listado_vuelos_kiu">
    <div class="">
      <modalComponent :titulo_modal="'Crear Manifiesto'">
          <template v-slot:bodyModal>
             hoy soy el body :v
          </template>
          <template v-slot:buttonsModal>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </template>
      </modalComponent>

      <div class="row">
        <div class="col-lg-12">
          <div class="col-lg-3">
            <div class="form-group">
               <input name="button" type="button" class="btn btn-danger button" id="button" data-toggle="modal" data-target="#modalCrearEditarManifiesto" value="Agregar Manifiesto" @click="CrearManifiesto()">
            </div>
          </div>
        </div>
      </div>
       
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12">
                <div class="col-lg-12">
                  <table v-show="tablereadyshow" id="myTable" class="table-hover table table-striped table-bordered"
                    border="0" align="center" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id File</th>
                            <th>Nombre Archivo</th>
                            <th>Vuelo</th>
                            <th>Fecha</th>
                            <th>Origen</th>
                            <th># Pax</th>
                            <th>Id Mani.</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row,index) in cabeceraFile" :style="{border:msg}">
                            <td>{{row.idFileTuua}}</td>
                            <td align="center">{{row.nombreArchivo}}</td>
                            <td align="center">{{row.nroVuelo}}</td>
                            <td align="center">{{row.Fecha}}</td>
                            <td align="center">{{row.aeroEmbarque}}</td>
                            <td align="center">{{row.Pax}}</td>
                            <td align="center">{{row.IdManifiesto}}</td>
                            <td align="left">{{row.nEstado}} - {{row.Estado}}</td>
                            <td>
                                <div :id="'id_procesa_'+row.Boleto+'_'+row.Cupon">

                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td v-if="row.Pax>0" width="" align="center"> <a href="javascript:void(0)"
                                                    title="Importar Pax"><img src="images/import.png"> </a> </td>
                                            <td v-else width="" align="center"> <a href="javascript:void(0)"
                                                    @click="ImportarPax(row.idFileTuua,row.nroVuelo,row.Fecha,row.aeroEmbarque)"
                                                    title="Importar Pax"><img src="images/import.png"> </a> </td>
                                            <!--<td width="" align="center"> <a  href="ta_detalle_vuelo_kiu.php?id=<?php echo $resulta[$i]["idFileTuua"]; ?>" title="Ver Detalle de Pax"><img src="images/pasajero.gif" > </a> </td>-->
                                            <td width="" align="center"> <a
                                                    :href="'/intranet/app/tuua/index/'+row.idFileTuua"
                                                    title="Ver Detalle de Pax"><img src="images/pasajero.gif"> </a>
                                            </td>
                                            <!--<td width="" align="center"><a href="ta_sendADP.php?idTuuaFile=<?php echo $resulta[$i]["idFileTuua"]; ?>" title="Re-Procesa TUUA"><img src="img/proce.jpg" width="50" height="10" /></a></td>-->
                                            <td width="" align="center"><a href="javascript:void(0)"
                                                    @click="Reprocesar(row.idFileTuua,row.aeroEmbarque)"
                                                    title="Re-Procesa TUUA"><img src="img/proce.jpg" width="50"
                                                        height="10" /></a></td>

                                            <td width="" align="center"><a href="javascript:void(0)"
                                                    @click="Actualizar(row.idFileTuua)" title="Actualizar"><img
                                                        src="images/modificar.png" width="20" height="20"></a></td>
                                            <td width="" align="center"><a href="javascript:void(0)"
                                                    @click="Eliminar(row.idFileTuua)" title="Eliminar"><img
                                                        src="images/delete.png" width="20" height="20"></a></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import modalComponent from '../modalComponent.vue';

export default {
    name: 'ta_listado_vuelos_kiu',
    props:['idFileTuuaUno','fecha_ini','fecha_fin','origen'],
    components: { 
      modalComponent,
    },
    data:()=>({
        cabeceraFile:[],
        msg:'2px solid red',
        tablereadyshow:false,
     }),
    created:function(){
     },
    mounted:function(){
     // let users = [];
      this.init_ta_listado_vuelos_kiu();
    },
    methods:{ 
        init_ta_listado_vuelos_kiu(){
            var self = this; 
            axios({
                method: 'POST',
                url: 'init_ta_listado_vuelos_kiu?view',
                params: {idFileTuuaUno:'',txtpasajero:'',fecha1:this.fecha_ini,fecha2:this.fecha_fin,origen:this.origen}
            }).then((response) => {
                    //
                    var data = response.data.data;
                    console.log(data)
                    self.cabeceraFile = data;
                    setTimeout(() => {
                     $('#myTable').DataTable({
                        "language":{
                           "sProcessing":     "Procesando...",
                            "sLengthMenu":     "Mostrar _MENU_ registros",
                            "sZeroRecords":    "No se encontraron resultados",
                            "sEmptyTable":     "Ningún dato disponible en esta tabla",
                            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix":    "",
                            "sSearch":         "Buscar:",
                            "sUrl":            "",
                            "sInfoThousands":  ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "oAria": {
                                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            }
                        }
                           
                        });
                      self.tablereadyshow=true;
                    }, 150);

                    /*self.dataTable.draw(false);
                    self.cabeceraFile = data.data;*/
                    /*for (let index = 0; index < data.length; index++) {
                      const element = array[index];
                      
                    }*/
                       //self.dataTable.row.add([1,2,3]).draw(false)
                    /* */
                   

            })
            .catch((error) => error);
        },
        CrearManifiesto(){
                $("#frm_crear_manifiesto").dialog({	
                  title:" Crear Manifiesto",				
                  modal: true,	
                  width: 500,
                  minWidth: 400,
                  maxWidth: 650,
                  height: 300,
                  show: "fold",
                  buttons:{
                    "Crear":function(){
                    
                        fecha_vuelo=$("#fecha_vuelo").val();
                        nro_vuelo=$("#nro_vuelo").val();
                        origen=$("#origen").val();
                        hora_despegue=$("#hora_despegue").val();
                        hora_cierra_despegue=$("#hora_cierra_despegue").val();
                        hora_llegada_destino=$("#hora_llegada_destino").val();
                        matricula_avion=$("#matricula_avion").val();
                    
                      
              
              
              
                    if ( /(?:19|20)[0-9]{2}-(?:0[1-9]|1[0-2])-(?:0[1-9]|[12][0-9]|3[01])/.test(fecha_vuelo)) {
                      }else{ alert("la fecha de vuelo no es correcta"); $( "#fecha_vuelo" ).focus();return false;}
                    
                    if ( /^[0-9]{3,4}$/.test(nro_vuelo) ) {
                      }else{ alert("El numero de vuelo no es correcto"); $( "#nro_vuelo" ).focus();return false;}
                    
                    if ( /^[AQP,CUZ,IQT,LIM,PIU,TCQ,PCL,TPP]{3}$/.test(origen) ) {
                      }else{ alert("El origen no es correcto"); $( "#origen" ).focus(); return false;}
                    
                    if ( /^[0-9]{4}$/.test(hora_despegue) ) {
                      }else{ alert("La hora Despegue no es correcta"); $( "#hora_despegue" ).focus(); return false;}
                    
                    if ( /^[0-9]{4}$/.test(hora_cierra_despegue) ) {
                      }else{ alert("La hora_cierra_despegue no es correcto"); $( "#hora_cierra_despegue" ).focus(); return false;}
                    
                    if ( /^[0-9]{4}$/.test(hora_llegada_destino) ) {
                      }else{ alert("La hora_llegada_destino no es correcto"); $( "#hora_llegada_destino" ).focus(); return false;}
                    
                    if ( /^[A-Z]{1,2}[0-9]{4}$/.test(matricula_avion) ) {
                      }else{ alert("La matricula_avion no es correcta");$( "#matricula_avion" ).focus(); return false;}
                    
                    
                      $.ajax({
                        type : "POST",
                        url : "./controller/AdpController.php", 
                        data : "flag=CrearManifiesto&fecha_vuelo="+fecha_vuelo+"&nro_vuelo="+nro_vuelo+"&origen="+origen+"&hora_despegue="+hora_despegue+"&hora_cierra_despegue="+hora_cierra_despegue+"&hora_llegada_destino="+hora_llegada_destino+"&matricula_avion="+matricula_avion,	 		
                        success:function(data){		
                              //alert(data);									 
                        $("#fecha_vuelo").val("");
                        $("#nro_vuelo").val("");
                        $("#origen").val("");
                        $("#hora_despegue").val("");
                        $("#hora_cierra_despegue").val("");
                        $("#hora_llegada_destino").val("");
                        $("#matricula_avion").val("");
                        console.log(data);
                              
                          }				
                        });		
                        
                      
                      buscarVuelos();	
                      $(this).dialog("close");
                      
                      },
                      "Cancelar":function(){
                      $("#fecha_vuelo").val("");
                      $("#nro_vuelo").val("");
                      $("#origen").val("");
                      $("#hora_despegue").val("");
                      $("#hora_cierra_despegue").val("");
                      $("#hora_llegada_destino").val("");
                      $("#matricula_avion").val(""); 
                      
                      $(this).dialog("close");
                      
                      } 
                  }		
              });
			
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

