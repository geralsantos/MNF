<template id="tableComponent">
    <div class="" >  
        <table id="myTable" class="table-hover table table-striped table-bordered"
                    border="0" align="center" cellpadding="0" cellspacing="0">
            <thead>
                <slot name="tableHeader"></slot>
            </thead>
            <tbody>
                <slot name="tableBody"></slot>
            </tbody>
        </table>
    </div> 
</template>
<script>

export default {
    name: 'tableComponent',
    props:[],
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

