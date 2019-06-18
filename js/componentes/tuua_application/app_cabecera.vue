<template id="app_cabecera">
    <div class="" > 
        app_cabecera {{url_envia}}
        <div align="center"><span><img :src="this.url_envia+'/img/banner.jpg'"></span></div>
    </div> 
</template>
<script>
import variable_entorno from '../../variable_entorno.js';

export default {
    name: 'app_cabecera',
    props:['url_envia'],
    components: { },
    data:()=>({
        url_printer:'',
     }),
    created:function(){
     },
    mounted:function(){
        console.log(variable_entorno.SITE_URL_DIR);

        //this.url_printer = this.url_printer==this.url_envia ? "" : this.urlenvia;

     // this.cargar_datos_usuario();

    },
    methods:{}
}
</script>

