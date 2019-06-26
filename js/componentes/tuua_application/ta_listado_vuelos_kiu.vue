<template id="ta_listado_vuelos_kiu">
    <div class="">
      
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12">
                <div class="col-lg-12">
                  <tableComponent v-show="tablereadyshow">
                    <template v-slot:tableHeader>
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
                    </template>
                    <template v-slot:tableBody>
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
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Opciones
                                    </button>
                                    <div class="dropdown-menu">
                                        <button type="button" class="dropdown-item " @click="ImportarPax(row)">ImportarPax</button>
                                        <button type="button" class="dropdown-item " @click="IrDetallePax(row.idFileTuua)">Ver Detalle de Pax</button>
                                        <button type="button" class="dropdown-item " @click="Reprocesar(row.idFileTuua,row.aeroEmbarque)">Reprocesar</button>
                                        <button type="button" class="dropdown-item " @click="EditarItem(row)">Modificar</button>
                                        <div class="dropdown-divider"></div>
                                        <button type="button" class="dropdown-item text-danger" @click="Eliminar(row.idFileTuua)">Eliminar</button>
                                    </div>
                                  </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                  </tableComponent>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import variable_entorno from '../../variable_entorno.js';
import tableComponent from '../tableComponent.vue';
import Swal from 'sweetalert2'
import appVue from '../app.vue';

export default {
    name: 'ta_listado_vuelos_kiu',
    props:['EditarItem','buscarVuelos','idFileTuuaUno','fecha_ini','fecha_fin','origen'],
    components: { 
      tableComponent
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
        abrirManifiesto(){
          this.limpiarValoresManifiesto();
        },
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
                      variable_entorno.INIT_TABLE();
                      self.tablereadyshow=true;
                    }, 150);
            })
            .catch((error) => error);
        },
        ImportarPax(row){
          let idFileTuua=row.idFileTuua,nroVuelo=row.nroVuelo,Fecha=row.Fecha,aeroEmbarque=row.aeroEmbarque;
          var self = this;
          Swal.fire({
            title: 'Esta seguro que desea importar los pasajeros del vuelo: '+idFileTuua+' ?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si'
          }).then((result) => {
            if (result.value) {
              axios({
                  method: 'POST',
                  url: 'AdpController?view',
                  params: {flag:'ImportarPax',nroVuelo:nroVuelo,Fecha:Fecha,aeroEmbarque:aeroEmbarque,idFileTuua:idFileTuua}
              }).then((response) => {
                  let data = response.data;
                  Swal.fire(data["result"],data["mensaje"],data["icon"]);
                  self.buscarVuelos();
              })
              .catch((error) => {
                console.log(error);
                Swal.fire("error",error,"error");
              });
            }
          })
        },
        IrDetallePax(idFileTuua){
          window.open('ta_listado_pax?q='+idFileTuua,'_blank');
          //location.href='ta_listado_pax?q='+idFileTuua;
        },
        Reprocesar(idFileTuua,embarque){
          var self = this;
          Swal.fire({
            title: 'Esta seguro que desea reprocesar el manifiesto: '+idFileTuua+' ?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si'
          }).then((result) => {
            if (result.value) {
              axios({
                  method: 'POST',
                  url: 'AdpController?view',
                  params: {flag:'Reprocesar',id_file:idFileTuua,embarque:embarque}
              }).then((response) => {
                  let data = response.data;
                  Swal.fire(data["result"],data["mensaje"],data["icon"]);
                  self.buscarVuelos();
              })
              .catch((error) => {
                console.log(error);
                Swal.fire("error",error,"error");
              });
            }
          })
        },
        Eliminar(idFileTuua){
          var self = this;
          Swal.fire({
            title: 'Esta seguro que desea eliminar el manifiesto: '+idFileTuua+' ?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si'
          }).then((result) => {
            if (result.value) {
              axios({
                  method: 'POST',
                  url: 'AdpController?view',
                  params: {flag:'EliminarManifiesto',idFileTuua:idFileTuua}
              }).then((response) => {
                  let data = response.data;
                  Swal.fire(data["result"],data["mensaje"],data["icon"]);
                  self.buscarVuelos();
              })
              .catch((error) => {
                console.log(error);
                Swal.fire("error",error,"error");
              });
            }
          })
        }
    }
}
</script>

