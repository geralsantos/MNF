<template id="ta_listado_vuelos">
    <div class="" >
        <input id="flag" value="" type="hidden">
        <div id="reprocesar"></div>
        <div id="importarPax"></div>
        <template v-if="false">
          <div id ="frm_crear_manifiesto">
              <div class="fila"><span>Fecha Vuelo : </span><input type="text" id="fecha_vuelo" v-model="CMfecha_vuelo.value" :disabled="CMfecha_vuelo.disabled" placeholder="Ejemplo " /></div>
              <div class="fila"><span>Nro Vuelo : </span><input type="text" id="nro_vuelo" v-model="CMnro_vuelo.value" :disabled="CMnro_vuelo.disabled" placeholder="Ejemplo 230" /></div>
              <div class="fila"><span>Origen : </span><input type="text" id="origen" v-model="CMorigen.value"   :disabled="CMorigen.disabled" placeholder="Ejemplo LIM"/></div>
              <div class="fila"><span>C/P Itin : </span><input type="text" id="hora_despegue" v-model="CMhora_despegue.value" :disabled="CMhora_despegue.disabled" placeholder="Ejemplo 0600"/></div>
              <div class="fila"><span>C/P : </span><input type="text" id="hora_cierra_despegue" v-model="CMhora_cierra_despegue.value" :disabled="CMhora_cierra_despegue.disabled" placeholder="Ejemplo 0601"/></div>
              <div class="fila"><span>Arr - In : </span><input type="text" id="hora_llegada_destino" v-model="CMhora_llegada_destino.value" :disabled="CMhora_llegada_destino.disabled" placeholder="Ejemplo 0701"/></div>
              <div class="fila"><span>Matricula : </span><input type="text" id="matricula_avion" v-model="CMmatricula_avion.value" :disabled="CMmatricula_avion.disabled"  placeholder="Ejemplo OB2079"/></div>
          </div>
        </template>
        
  <div class="panel panel-default">

    <div class="panel-heading">Busqueda de Vuelos</div>

    <div class="panel-body">
 
   <div align="center">
       
     <span class="subtitulo_rojo">Busqueda de Vuelos</span></div>
     
            <form name="frm" method="get" action="">
         
                 F. Inicio
 <div class="row">
                            <div class="col-md-3">
                              <date-picker name="date" v-model="fecha_ini" :config="options"></date-picker>
                            </div>
                </div>
                F. Fin
                        <div class="row">
                            <div class="col-md-3">
                              <date-picker name="date" v-model="fecha_fin" :config="options"></date-picker>
                            </div>
                          </div>
               
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Origen</span>
                  </div>
                  <input name="txtOrigen"  class="form-control" placeholder="Origen" type="text" id="txtOrigen" size="5" :disabled="disabled" v-model="origen"  >
                  <input type="hidden" name="op" id="op" value="2">
                  <div  id="div_msg_error"> </div>  

                </div>
                <input class="btn btn-primary button buscar_vuelo" id="button" name="button" type="button" @click="buscarVuelos();" value="Buscar">
            
          </form>
         
        <!--<div id="busca_vuelos"> &nbsp; </div>-->
        <talistadovueloskiu v-if="showtalistadovueloskiu"></talistadovueloskiu>
    <input type="hidden" name="idFileTuua" id="idFileTuua" v-model="idFileTuua">
    </div>
  </div>
</div> 
</template>
<script>
 import datePicker from 'vue-bootstrap-datetimepicker';
import variable_entorno from '../../variable_entorno.js';
import talistadovueloskiu from './ta_listado_vuelos_kiu.vue';

export default {
    name: 'ta_listado_vuelos',
    components: {
       datePicker,
       talistadovueloskiu
    },
    data:()=>({
        options: {
           format: 'YYYY/MM/DD',
          useCurrent: false,
          showClear: true,
          showClose: true,
        },
        showtalistadovueloskiu:false,
        url_envia: variable_entorno.ASSETS,
        fecha_ini:'',
        fecha_fin:'',
        disabled:false,
        origen:'',
        idFileTuua:'',
        CMfecha_vuelo:{
          disabled:false,
          value:'',
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
    methods:{
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
        this.CMfecha_vuelo.disabled = false;
        this.CMnro_vuelo.disabled = false;
        this.CMorigen.disabled = false;
        console.log(this.CMfecha_vuelo);
        
          let txtpasajero,fecha1,fecha2,ckcBusca,origen;
          fecha1=this.fecha_ini;
          fecha2=this.fecha_fin;
          origen=this.origen;
          this.showtalistadovueloskiu=true;
        /*  var previousInnerHTML = new String();                      
          previousInnerHTML = previousInnerHTML.concat("");                
          document.getElementById('div_msg_error').innerHTML = previousInnerHTML;		*/		

          /*var previousInnerHTML = new String();
          previousInnerHTML = previousInnerHTML.concat("<table border=0 cellpadding=0 cellspacing=0 aling=center><tr><td>&nbsp;</td></tr><tr><td align=center><img src=img/logo.jpg></td></tr><tr><td align=center><img src=img/proceso.gif width=230></td></tr></table>");                
          document.getElementById('busca_vuelos').innerHTML = previousInnerHTML;	
          fAjax('ta_listado_vuelos_kiu.php','&fecha1=' + fecha1 + '&fecha2=' + fecha2 + '&origen=' +  origen+ '&idFileTuuaUno=' +  idFileTuua, 'busca_vuelos');*/
      }
    }
}
          $.extend(true, $.fn.datepicker.defaults, {
  icons: {
    time: 'far fa-clock',
    date: 'far fa-calendar',
    up: 'fas fa-arrow-up',
    down: 'fas fa-arrow-down',
    previous: 'fas fa-chevron-left',
    next: 'fas fa-chevron-right',
    today: 'fas fa-calendar-check',
    clear: 'far fa-trash-alt',
    close: 'far fa-times-circle'
  }
});
</script>

