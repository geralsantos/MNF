<template id="ta_listado_vuelos">
    <div class="">
          <modalComponent :idmodal="'modalCrearEditarManifiesto'" :titulo_modal="'Crear Manifiesto'">
            <template v-slot:bodyModal>
              <input id="flag" value="" type="hidden">
              <div id="reprocesar"></div>
              <div id="importarPax"></div>
              <div class="container"> 
                <div class="row">
                  <div class="col-lg-12">
                    <label for="dateFInicio">Fecha Vuelo</label>
                      <date-picker id="fecha_vuelo" class="form-control" name="date" v-model="CMfecha_vuelo.value" :config="options" :disabled="CMfecha_vuelo.disabled"></date-picker>
                  </div>
                  <div class="col-lg-12">
                    <label for="dateFInicio">Nro Vuelo</label>
                    <input type="number" class="form-control" id="nro_vuelo" v-model="CMnro_vuelo.value"
                      :disabled="CMnro_vuelo.disabled" placeholder="Ejemplo 230" />
                  </div>
                  <div class="col-lg-12">
                    <label for="dateFInicio">Origen</label>
                    <input type="text" class="form-control" id="origen" v-model="CMorigen.value"
                      :disabled="CMorigen.disabled" placeholder="Ejemplo LIM" />
                  </div>
                  <div class="col-lg-12">
                    <label for="dateFInicio">C/P Itin</label>
                    <input type="text" class="form-control" id="hora_despegue" v-model="CMhora_despegue.value" :disabled="CMhora_despegue.disabled" placeholder="Ejemplo 0600" />
                  </div>
                  <div class="col-lg-12">
                    <label for="dateFInicio">C/P</label>
                    <input type="text" class="form-control" id="hora_cierra_despegue" v-model="CMhora_cierra_despegue.value" :disabled="CMhora_cierra_despegue.disabled"
                      placeholder="Ejemplo 0601" />
                  </div>
                  <div class="col-lg-12">
                    <label for="dateFInicio">Arr - In</label>
                    <input type="text" class="form-control" id="hora_llegada_destino" v-model="CMhora_llegada_destino.value" :disabled="CMhora_llegada_destino.disabled"
                      placeholder="Ejemplo 0701" />
                  </div>
                  <div class="col-lg-12">
                    <label for="dateFInicio">Matricula</label>
                    <input type="text" class="form-control" id="matricula_avion"  v-model="CMmatricula_avion.value" :disabled="CMmatricula_avion.disabled"
                      placeholder="Ejemplo OB2079" />
                  </div>
                </div>
              </div>
            </template>
            <template v-slot:buttonsModal>
              <button type="button" class="btn btn-secondary" data-dismiss="modal" ref="modalManifiestoCancelar">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="CrearModificarManifiesto()">Guardar cambios</button>
            </template>
          </modalComponent>
        <div class="panel panel-default">
            <div class="panel-heading">Busqueda de Vuelos</div>
            <div class="panel-body">
                <div align="center">
                    <span class="subtitulo_rojo">Busqueda de Vuelos</span>
                </div>
              
                <form name="frm" method="get" action="" @keyup.enter="trigger()">
                  <div class="">
                    <div class="row">
                      <div class="col col-lg-3 col-12">
                        <div class="form-group">
                          <label for="dateFInicio">F. Inicio</label>
                          <date-picker id="dateFInicio" class="form-control" name="date" v-model="fecha_ini" :config="options"></date-picker>
                        </div>
                      </div>
                      <div class="col col-lg-3 col-12">
                        <div class="form-group">
                          <label for="dateFFin">F. Fin</label>
                          <date-picker name="date" id="dateFFin" class="form-control" v-model="fecha_fin" :config="options"></date-picker>
                        </div>
                      </div>
                      <div class="col col-lg-3 col-12">
                        <div class="form-group">
                          <label for="dateFFin">Origen</label>
                          <input name="txtOrigen" autocomplete="true" class="form-control" placeholder="Origen" type="text" id="txtOrigen"
                                  size="5" :disabled="disabled" :value="origen" @input="origen = $event.target.value.toUpperCase()" >
                              <input type="hidden" name="op" id="op" value="2">
                              <div id="div_msg_error"> </div>
                        </div>
                      </div> 
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                              <input class="btn btn-primary button buscar_vuelo" v-if="(!utils.isempty(fecha_ini)&&!utils.isempty(fecha_fin)&&!utils.isempty(origen))" ref="sendReply" id="button" name="button" type="button" @click="buscarVuelos();" value="Buscar">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                              <input name="button" type="button" class="btn btn-danger button" id="button" data-toggle="modal" data-target="#modalCrearEditarManifiesto" @click="limpiarValoresManifiesto();editItem=false;" value="Agregar Manifiesto" >
                            </div>
                        </div>
                    </div>
                  </div>
                </form>
                <!--<div id="busca_vuelos"> &nbsp; </div>-->
                <talistadovueloskiu v-if="showtalistadovueloskiu" :EditarItem="EditarItem" :buscarVuelos="buscarVuelos" :idFileTuuaUno="false" :fecha_ini="fecha_ini"
                    :fecha_fin="fecha_fin" :origen="origen"></talistadovueloskiu>
                <input type="hidden" name="idFileTuua" id="idFileTuua" v-model="idFileTuua">
            </div>
        </div>
    </div>
</template>
<script>
  import datePicker from 'vue-bootstrap-datetimepicker';
  import variable_entorno from '../../variable_entorno.js';
  import talistadovueloskiu from './ta_listado_vuelos_kiu.vue';
  import utils from '../../utils.js';
  import modalComponent from '../modalComponent.vue';
  import Swal from 'sweetalert2'
export default {
    name: 'ta_listado_vuelos',
    components: {
       datePicker,
       talistadovueloskiu,
       utils,
      modalComponent,

    },
    data:()=>({
        options: {
           format: 'YYYY-MM-DD',
          useCurrent: false,
          showClear: true,
          showClose: true,
          locale: 'es',
        },
        showtalistadovueloskiu:false,
        url_envia: variable_entorno.ASSETS,
        utils:utils,
        fecha_ini:'',
        fecha_fin:'',
        disabled:false,
        origen:'',
        idFileTuua:'',
        editItem:false,
        CMfecha_vuelo:{
          disabled:false,
          value:moment().format("YYYY-MM-DD"),
        },
        CMnro_vuelo:{
           disabled:false,
          value:'',
        },
        CMorigen:{
           disabled:false,
          value:'',
        },
        CMhora_despegue:{
           disabled:false,
          value:'',
        },
        CMhora_cierra_despegue:{
           disabled:false,
          value:'',
        },
        CMhora_llegada_destino:{
           disabled:false,
          value:'',
        },
        CMmatricula_avion:{
           disabled:false,
          value:'',
        },
    }),
    created:function(){
    },
    mounted:function(){
      this.init_listado_vuelos();
     // this.cargar_datos_usuario();

    },
    watch:{
    },
    methods:{ 
      trigger () {
        this.$refs.sendReply.click()
      },
      triggerActionByRef(ref){
        this.$refs[ref].click()
      },
      init_listado_vuelos(){
        var self = this;
        axios.get('init_listado_vuelos?view').then(function(response){
          let data = response.data;
          console.log(data)
          self.fecha_ini = data.fecha_ini;
          self.fecha_fin = data.fecha_fin;
          self.disabled = data.disabled || false;
          self.idFileTuua = data.idFileTuua;
          self.origen = data.origen;
        });
      },
      buscarVuelos(){
        this.showtalistadovueloskiu=false;
        this.CMfecha_vuelo.disabled = false;
        this.CMnro_vuelo.disabled = false;
        this.CMorigen.disabled = false;
        let txtpasajero,fecha1,fecha2,ckcBusca,origen;
        fecha1=this.fecha_ini;
        fecha2=this.fecha_fin;
        origen=this.origen;
        var self = this;
        setTimeout(() => {
          self.showtalistadovueloskiu=true;
        }, 200);
      },
      limpiarValoresManifiesto(){
          this.CMfecha_vuelo.disabled=false;
          this.CMnro_vuelo.disabled=false;
          this.CMorigen.disabled=false;
          this.idFileTuua='';
          this.CMfecha_vuelo.value=moment().format("YYYY-MM-DD");
          this.CMnro_vuelo.value= '';
          this.CMorigen.value=''
          this.CMhora_despegue.value='';
          this.CMhora_cierra_despegue.value='';
          this.CMhora_llegada_destino.value='';
          this.CMmatricula_avion.value='';
      },
       CrearModificarManifiesto(){
          let fecha_vuelo=this.CMfecha_vuelo.value,
          nro_vuelo=this.CMnro_vuelo.value,
          origen=this.CMorigen.value,
          hora_despegue=this.CMhora_despegue.value,
          hora_cierra_despegue=this.CMhora_cierra_despegue.value,
          hora_llegada_destino=this.CMhora_llegada_destino.value,
          matricula_avion=this.CMmatricula_avion.value,
          regValidacion = ['(?:19|20)[0-9]{2}-(?:0[1-9]|1[0-2])-(?:0[1-9]|[12][0-9]|3[01])','^[0-9]{3,4}$','^[AQP,CUZ,IQT,LIM,PIU,TCQ,PCL,TPP]{3}$','^[0-9]{4}$','^[0-9]{4}$','^[0-9]{4}$','^[A-Z]{1,2}[0-9]{4}$'],
          valores = [fecha_vuelo,nro_vuelo,origen,hora_despegue,hora_cierra_despegue,hora_llegada_destino,matricula_avion],
          mensajes =["la fecha de vuelo no es correcta","El numero de vuelo no es correcto","El origen no es correcto","La hora Despegue no es correcta","La hora_cierra_despegue no es correcto","La hora_llegada_destino no es correcto","La matricula_avion no es correcta"];
          console.log(fecha_vuelo);
          
          for (let index = 0; index < regValidacion.length; index++) {
            let regx = new RegExp(regValidacion[index]);
            if (!(regx.test(valores[index]))) {
              Swal.fire("Error",mensajes[index],"warning");
              return false;
            }
          }
          var self = this;
          let params =  {flag:'CrearManifiesto',fecha_vuelo:fecha_vuelo,nro_vuelo:nro_vuelo,origen:origen,hora_despegue:hora_despegue,hora_cierra_despegue:hora_cierra_despegue,hora_llegada_destino:hora_llegada_destino,matricula_avion:matricula_avion};
          if (this.editItem) {
            params.flag = 'ActualizarManifiesto';
            params.idFileTuua = this.idFileTuua;
          }
          axios({
              method: 'POST',
              url: 'AdpController?view',
              params: params
          }).then((response) => {
              let data = response.data;
              Swal.fire(data["result"],data["mensaje"],data["icon"]);
              self.buscarVuelos();
              self.triggerActionByRef('modalManifiestoCancelar');
          })
          .catch((error) => {
            console.log(error);
            Swal.fire("error",error,"error");
          });
        },
        EditarItem(row){
          console.log(row)
          this.editItem=true;
          this.CMfecha_vuelo.disabled=true;
          this.CMnro_vuelo.disabled=true;
          this.CMorigen.disabled=true;
          this.idFileTuua = row.idFileTuua;
          this.CMfecha_vuelo.value=moment(row.fecVueloTip,'DD/MM/YYYY').format('YYYY-MM-DD');
          this.CMnro_vuelo.value= (row.nroVuelo).replace('P90','');
          this.CMorigen.value=row.aeroEmbarque;
          this.CMhora_despegue.value=row.horaCierrePuerta;
          this.CMhora_cierra_despegue.value=row.horaCierreDespegue;
          this.CMhora_llegada_destino.value=row.horaLlegadaDestino;
          this.CMmatricula_avion.value=row.matriculaAvion;
          $("#modalCrearEditarManifiesto").modal()
        },
    }
}

</script>

