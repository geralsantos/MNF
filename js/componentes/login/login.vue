<template id="login">
    <div class="" >
      login
    </div> 
</template>
<script>
export default {
    name: 'login',
    components: {
    },
    data: () => ({
      user: {
        // email: 'admin@example.com',
        // password: 'admin',
        // name: 'John Doe',
      },
      options: {
        isLoggingIn: true,
        shouldStayLoggedIn: true,
      },
      currentView:'',
      usuario:'',
      contrasena:'',
      repita_contrasena:'',
      email:'',
      repita_email:'',
      nombre:'',
      apellido:'',
      loader:false,
    }),
    created:function(){
    },mounted:function(){
      //appVue.culqi = $('#culqi').attr("data-id");
      //appVue.autopenCulqi();
    },
    methods: {
      submitForm(){
      	var form = document.getElementById("loginForm");
        form.submit();
      },
      registro_login:function(){
        if (this.usuario!=""&&this.contrasena!=""&&this.repita_contrasena!=""&&this.email!=""&&this.repita_email!="") {
          if (this.contrasena!=this.repita_contrasena) {
            swal("Error","la contraseña no coincide con el campo  \"Repita Contraseña\" ","warning");
            return false;
          }else if(this.email!=this.repita_email){
            swal("Error","El email no coincide con el campo  \"Repita Email\" ","warning");
            return false;
          }
            let params={usuario:this.usuario,contrasena:this.contrasena,email:this.email };
           // appVue.openCulqi();
        }else{
          swal("Error","Debe llenar todos los campos","warning");
        }
      }
    }
}
</script>

