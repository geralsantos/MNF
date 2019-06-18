Vue.use(VueRouter);
import router from './routes.js';

  var appVue = new Vue({
  el:'#vue_app',
  router,
  data: () => ({
    overlay:false,
    title_modulo:null,
    sidenavopen:"true",
    drawer: true,
      mini: true,
      right: null,
      rowsmodulos:[],
      currentView:'',
  }),
  created:function(){
  },mounted:function(){
    this.listar_menu();
    window.addEventListener('click',this.mini_clickoutside);
    this.action_modulos_activos();
  },
  watch:{
   
  },
  methods: {
    cerrar(){
      window.location.assign('/MNF/acceso/cerrar');
    },
    listar_menu(){
      console.log("menu-rincipal-portada-index");
      let self = this;
      /*axios.get('list_modulos?view').then(function(response){
          console.log(response.data)
          self.rowsmodulos=response.data;
      });*/
  },
  mini_clickoutside(e){
   //this.mini = !document.getElementById('mini').contains(e.target);
  },
  action_modulos_activos(){
    var btns = document.querySelectorAll(".theme--dark.v-list .v-list__tile--link");
    for (var i = 0; i < btns.length; i++) {
      btns[i].addEventListener("click", function() {
        console.log(this.getAttribute("href"));
        if (this.getAttribute("href")!="#") {
          for (var x = 0; x < btns.length; x++) {
            if (this.getAttribute("href")!=btns[x].getAttribute("href")) {
              btns[x].classList.remove("active-menu-option");
            }
          }
          this.className += " active-menu-option";
        }
      });
    }
  },
    toggleMenu () {
      this.menuVisible = !this.menuVisible;
    },
    changeview(val){
      this.currentView=val;
        //document.querySelector('.comprobantesestado').style.display= (val!="portadaindex"?'none':'');
    },
  }
});
  
