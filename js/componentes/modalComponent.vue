<template id="modalComponent">
    <div class="" >  

   <div class="modal fade" id="modalCrearEditarManifiesto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{titulo_modal}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <slot name="bodyModal"></slot>
      </div>
      <div class="modal-footer">
            <slot name="buttonsModal"> </slot>
      </div>
    </div>
  </div>
</div>
    </div> 
</template>
<script>

export default {
    name: 'modalComponent',
    props:['titulo_modal'],
    components: { },
    data:()=>({
     }),
    created:function(){
     },
    mounted:function(){

        //this.url_printer = this.url_printer==this.url_envia ? "" : this.urlenvia;

     // this.cargar_datos_usuario();

    },
    methods:{}
}
</script>

