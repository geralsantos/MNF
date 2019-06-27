<template id="ta_listado_pax">
    <div class="">
        <modalComponent :idmodal="'modificarPasajero'" :titulo_modal="editedIndex>0?'Modificar Pasajero':'Agregar Pasajero'">
            <template v-slot:bodyModal>
                <div class="container"> 
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="nroTicket">Nro Ticket</label>
                            <input type="number" class="form-control" id="nroTicket" v-model="editedItem.nroTicketPax" placeholder="" />
                            <small id="emailHelp" class="form-text text-muted">13 digitos</small>
                        </div>
                        <div class="col-lg-6">
                            <label for="Apellido">Apellido</label>
                            <input type="text" class="form-control"  id="Apellido" v-model="editedItem.apellidoPax" @input="editedItem.apellidoPax = $event.target.value.toUpperCase()"/>
                            <small id="emailHelp" class="form-text text-muted">Solo letras</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="Nombre">Nombre</label>
                        <input type="text" class="form-control" id="Nombre" v-model="editedItem.nombrePax" @input="editedItem.nombrePax = $event.target.value.toUpperCase()"/>
                        <small id="emailHelp" class="form-text text-muted">Solo letras</small>
                        </div>
                        <div class="col-lg-6">
                            <label for="Pax">Pax</label>
                            <input type="text" class="form-control" id="Pax" v-model="editedItem.tipoPax" @input="editedItem.tipoPax = $event.target.value.toUpperCase()"/>
                            <small id="emailHelp" class="form-text text-muted">Solo 1 letra</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="Foid">Foid</label>
                            <input type="text" class="form-control" id="Foid" v-model="editedItem.foidPax" @input="editedItem.foidPax = $event.target.value.toUpperCase()"/>
                            <small id="emailHelp" class="form-text text-muted">Solo 2 letras y el resto números</small>
                        </div>
                        <div class="col-lg-6">
                            <label for="Destino">Destino</label>
                            <input type="text" class="form-control" id="Destino" v-model="editedItem.destinoPax" @input="editedItem.destinoPax = $event.target.value.toUpperCase()"/>
                             <small id="emailHelp" class="form-text text-muted">Solo 3 letras</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="Clase">Clase</label>
                            <input type="text" class="form-control" id="Clase" v-model="editedItem.clasePax" @input="editedItem.clasePax = $event.target.value.toUpperCase()"/>
                            <small id="emailHelp" class="form-text text-muted">Solo 2 letras</small>
                        </div>
                        <div class="col-lg-6">
                            <label for="Cupon">Cupon</label>
                            <input type="number" class="form-control" id="Cupon" v-model="editedItem.nroCuponPax"/>
                            <small id="emailHelp" class="form-text text-muted">Solo 1 o 2</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="Ref">Ref</label>
                            <input type="number" class="form-control" id="Ref" v-model="editedItem.nroReferencia"/>
                            <small id="emailHelp" class="form-text text-muted">Solo 3 digitos</small>
                        </div>
                        <div class="col-lg-6">
                            <label for="Asiento">Asiento</label>
                            <input type="text" class="form-control" id="Asiento" v-model="editedItem.nroAsientoPax" @input="editedItem.nroAsientoPax = $event.target.value.toUpperCase()"/>
                            <small id="emailHelp" class="form-text text-muted">Solo 4 caracteres</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="NroDoc">Nro Doc</label>
                            <input type="text" class="form-control" id="NroDoc" v-model="editedItem.nroDoc"/>
                            
                        </div>
                        <div class="col-lg-6">
                            <label for="Nac">Nac</label>
                            <input type="text" class="form-control" id="Nac" v-model="editedItem.nacPax"/>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:buttonsModal>
              <button type="button" class="btn btn-secondary" data-dismiss="modal" ref="modalManifiestoCancelar">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="CrearModificarPasajero()">Guardar cambios</button>
            </template>
        </modalComponent>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered">
                    <tr class="table-danger">
                        <td colspan="3" align="center">Detalle del Vuelo</td>
                    </tr>
                    <tr>
                        <td>Id File Archivo : <span class="badge badge-primary"> {{cabecera.idFileTuua}}</span> </td>
                        <td>Nombre Archivo: <span class="badge badge-primary">{{cabecera.nombreArchivo}} </span></td>
                        <td># Vuelo: <span class="badge badge-primary">{{cabecera.nroVuelo}}</span></td>
                    </tr>
                    <tr>
                        <td>Fecha de Vuelo: <span class="badge badge-primary">{{cabecera.fecVueloTip}}</span></td>
                        <td>Matricula de Avion: <span class="badge badge-primary">{{cabecera.matriculaAvion}}</span></td>
                        <td>Cantidad de Pax: <span class="badge badge-primary">{{cantidad_pax.length}}</span></td>
                    </tr>
                    <tr>
                        <td>Ciudad Embarque: <span class="badge badge-primary">{{cabecera.aeroEmbarque}}</span></td>
                        <td>Estado de Envio: <span class="badge badge-primary">{{cabecera.Estado}}</span></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <input name="button" type="button" class="btn btn-danger button" id="button" data-toggle="modal" data-target="#modificarPasajero" @click="editedItem=defaultItem;editedIndex=-1" value="Agregar Pasajero" >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <tableComponent v-if="tablereadyrender" v-show="tablereadyshow">
                    <template v-slot:tableHeader>
                      <tr>
                          <th>Nro Ticket</th>
                          <th>Apellido</th>
                          <th>Nombre</th>
                          <th>Pax</th>
                          <th>Foid</th>
                          <th>Destino</th>
                          <th>Clase</th>
                          <th>Cupon</th>
                          <th>Ref</th>
                          <th>Asiento</th>
                          <th>Nro Doc.</th>
                          <th>Nac</th>
                          <th>Opciones</th>
                      </tr>
                    </template>
                    <template v-slot:tableBody>
                        <tr v-for="(row,index) in cantidad_pax" :class="{'table-danger':(!utils.isempty(row.color))}">
                            <td align="center">{{row.nroTicketPax}}</td>
                            <td align="center">{{row.apellidoPax}}</td>
                            <td align="center">{{row.nombrePax}}</td>
                            <td align="center">{{row.tipoPax}}</td>
                            <td align="center">{{row.foidPax}}</td>
                            <td align="center">{{row.destinoPax}}</td>
                            <td align="center">{{row.clasePax}}</td>
                            <td align="center">{{row.nroCuponPax}}</td>
                            <td align="center">{{row.nroReferencia}}</td>
                            <td align="center">{{row.nroAsientoPax}}</td>
                            <td align="center">{{row.nroDoc}}</td>
                            <td align="center">{{row.nacPax}}</td>
                            <td align="center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Opciones
                                    </button>
                                    <div class="dropdown-menu">
                                        <button type="button" class="dropdown-item " @click="EditarItem(row)">Modificar</button>
                                        <div class="dropdown-divider"></div>
                                        <button type="button" class="dropdown-item text-danger" @click="eliminarPasajero(row)">Eliminar</button>
                                    </div>
                                  </div>
                            </td>
                        </tr>
                    </template>
                </tableComponent>
            </div>
        </div>
    </div>
</template>
<script>
import utils from '../../utils.js';
import variable_entorno from '../../variable_entorno.js';
import modalComponent from '../modalComponent.vue';
import tableComponent from '../tableComponent.vue';
import Swal from 'sweetalert2'

export default {
    name: 'ta_listado_pax',
    props:[],
    components: {
        tableComponent,
        utils,
        modalComponent
    },
    data:()=>({
        utils:utils,
        cabecera:{
            idFileTuua:'',
            nombreArchivo:'',
            nroVuelo:'',
            fecVueloTip:'',
            matriculaAvion:'',
            aeroEmbarque:'',
            Estado:'',
        },
        editedIndex:-1,
        cantidad_pax:[],
        idItensPax:'',
        tablereadyshow:false,
        tablereadyrender:false,
        editedItem:{nroTicketPax:'',apellidoPax:'',nombrePax:'',tipoPax:'',foidPax:'',destinoPax:'',clasePax:'',nroCuponPax:'',nroReferencia:'',nroAsientoPax:'',nroDoc:'',nacPax:'',idItensPax:''},
        defaultItem:{nroTicketPax:'',apellidoPax:'',nombrePax:'',tipoPax:'',foidPax:'',destinoPax:'',clasePax:'',nroCuponPax:'',nroReferencia:'',nroAsientoPax:'',nroDoc:'',nacPax:'',idItensPax:''},
    }),
    created:function(){
     },
    mounted:function(){
        this.init_ta_listado_pax();
    },
    methods:{
        CrearModificarPasajero(){
            let regValidacion = ['^[0-9]{13}$','^[A-Z]*$','^[A-Z]*$','^[A,C,I]{1}$','^(PP|CN|NI|DL|ID)[0-9A-Z ]{4,20}$','^[AQP,CUZ,IQT,LIM,PIU,TCQ,PCL,TPP,LPB]{3}$','^[A-Z]{2}$','^[1-2]{1}$','^[0-9]{3}$','^[0-9]{1,3}[A-Z]{1}$'],
            valores = [this.editedItem.nroTicketPax,this.editedItem.apellidoPax,this.editedItem.nombrePax,this.editedItem.tipoPax,this.editedItem.foidPax,this.editedItem.destinoPax,this.editedItem.clasePax,this.editedItem.nroCuponPax,this.editedItem.nroReferencia,this.editedItem.nroAsientoPax],
            mensajes = ["El Nro Ticket solo permite 13 numeros","El Apellido solo permite letras","El Nombre solo permite letras","El campo Pax solo permite 1 letra A C I","El campo Foid solo permite 2 letras al inicio (PP CN NI DL ID), mas caracteres","El campo Destino solo permite 3 letras AQP CUZ IQT LIM PIU TCQ PCL TPP LPB","El campo Clase solo permite 2 letras","El campo Cupon solo permite 1 o 2","El campo Ref solo permite 3 digitos","El campo Asiento solo permite 4 caracteres"];
            for (let index = 0; index < regValidacion.length; index++) {
                let regx = new RegExp(regValidacion[index]);
                let valor = this.utils.removeSpaces(valores[index]);
                if (!(regx.test(valor)) || this.utils.isempty(valor)) {
                    Swal.fire("Error",mensajes[index],"warning");
                    return false;
                }
            }
            var self = this;
            let flag = 'CrearPasajero';
            if (this.editedIndex>0) {
                flag = 'ModificarPasajero';
                //this.editedItem.idItensPax = this.idItensPax;
            }
            this.editedItem.idFileTuua=this.idFileTuua;
            axios({
                method: 'POST',
                url: flag+'?view',
                params: self.editedItem
            }).then((response) => {
                let data = response.data;
                if (self.editedIndex > -1) {
                    Object.assign(self.cantidad_pax[self.editedIndex], self.editedItem)
                } else { 
                    self.cantidad_pax.push(self.editedItem);
                     self.tablereadyrender = false;
                    setTimeout(() => {
                        self.tablereadyrender = true;
                    }, 150);
                    setTimeout(() => {
                        variable_entorno.INIT_TABLE();
                        self.tablereadyshow=true;
                    }, 300);
                }
             
                Swal.fire(data["result"],data["mensaje"],data["icon"]);
            })
            .catch((error) => {
                console.log(error);
                Swal.fire("error",error,"error");
            });
        },
        EditarItem(row){
            console.log(row)
            this.editedIndex = this.cantidad_pax.indexOf(row);
            this.editedItem = Object.assign({}, row);
            $("#modificarPasajero").modal()
        },
        abrir_crear_pasajero(){
            this.editedItem = Object.assign({}, this.defaultItem)
            this.editedIndex = -1
        },
        init_ta_listado_pax(){
            var self=this;
            this.idFileTuua = self.$route.query.q;
            this.tablereadyrender=true;
            setTimeout(() => {
                variable_entorno.INIT_TABLE();
                self.tablereadyshow=true;
            }, 150);
            axios({
                  method: 'POST',
                  url: 'init_ta_listado_pax?view',
                  params: {id_file:self.idFileTuua}
              }).then((response) => {
                    let data = response.data;
                    self.cabecera.idFileTuua = data.cabecera[0].idFileTuua;
                    self.cabecera.nombreArchivo = data.cabecera[0].nombreArchivo;
                    self.cabecera.nroVuelo = data.cabecera[0].nroVuelo;
                    self.cabecera.fecVueloTip = data.cabecera[0].fecVueloTip;
                    self.cabecera.matriculaAvion = data.cabecera[0].matriculaAvion;
                    self.cabecera.aeroEmbarque = data.cabecera[0].aeroEmbarque;
                    self.cabecera.Estado = data.cabecera[0].Estado;
                    self.cantidad_pax=data.cantidad_pax;
              })
              .catch((error) => {
                console.log(error);
                Swal.fire("error",error,"error");
              });
        },
        eliminarPasajero(row){
            var self = this;
            Swal.fire({
                title: 'Esta seguro que desea eliminar al pasajero: '+row.nombrePax+' ?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
            }).then((result) => {
                if (result.value) {
                axios({
                    method: 'POST',
                    url: 'EliminarPasajero?view',
                    params: {idItensPax:row.idItensPax}
                }).then((response) => {
                    console.log(this.cantidad_pax);
                    let data = response.data;
                    const index = this.cantidad_pax.indexOf(row)
                    this.cantidad_pax.splice(index, 1);
                    console.log(this.cantidad_pax);
                    Swal.fire(data["result"],data["mensaje"],data["icon"]);
                })
                .catch((error) => {
                    Swal.fire("error",error,"error");
                });
                }
            })
        }
    }
}
</script>

