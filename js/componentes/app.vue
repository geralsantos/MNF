<template>
    <div>
        <v-toolbar color="white" grey>
                <v-toolbar-side-icon @click.stop="mini = !mini" style="margin-left:66px !important;">
                </v-toolbar-side-icon>

                <v-toolbar-title>TITULO MODULO</v-toolbar-title>

                <v-spacer></v-spacer>

                <v-btn icon>
                    <v-icon>search</v-icon>
                </v-btn>
            </v-toolbar>

            <template>
                <v-hover>
                    <v-navigation-drawer dark id="mini" v-model="drawer" class="navigation-drawer-manual" stateless
                        overlay :temporary="!mini" slot-scope="{ hover }" :mini-variant="mini && !hover" value="true"
                        style="position: fixed;">
                        <v-toolbar flat class="transparent">
                            <v-list class="pa-0">
                                <v-list-tile avatar>
                                    <v-list-tile-avatar>
                                        <img src="https://randomuser.me/api/portraits/men/85.jpg">
                                    </v-list-tile-avatar>

                                    <v-list-tile-content>
                                        <v-list-tile-title>John Leider</v-list-tile-title>
                                    </v-list-tile-content>

                                    <v-list-tile-action>
                                        <v-btn icon @click.stop="mini = !mini">
                                            <v-icon style="margin-top: -8px;">chevron_left</v-icon>
                                        </v-btn>
                                    </v-list-tile-action>
                                </v-list-tile>
                            </v-list>
                        </v-toolbar>
                        <v-list>
                            <div v-for="(row,index) in rowsmodulos" :href="'#'+row.url_module">

                                <v-list-group v-if="row.children" :prepend-icon="row.icon_module">
                                    <template v-slot:activator>
                                        <v-list-tile>
                                            <v-list-tile-title>{{row.name_module}}</v-list-tile-title>
                                        </v-list-tile>
                                    </template>

                                    <div v-for="(row,index) in row.children">
                                        <v-list-group v-if="row.children" :prepend-icon="row.icon_module">
                                            <template v-slot:activator>
                                                <v-list-tile>
                                                    <v-list-tile-title>{{row.name_module}}</v-list-tile-title>
                                                </v-list-tile>
                                            </template>
                                            <v-list-tile v-if="row.children==null" :href="'#'+row.url_module">
                                                <v-list-tile-action>
                                                    <v-icon>{{row.icon_module}}</v-icon>
                                                </v-list-tile-action>
                                                <v-list-tile-title>{{row.name_module}}</v-list-tile-title>
                                            </v-list-tile>
                                        </v-list-group>

                                        <v-list-tile v-if="row.children==null" :href="'#'+row.url_module">
                                            <v-list-tile-action>
                                                <v-icon>{{row.icon_module}}</v-icon>
                                            </v-list-tile-action>
                                            <v-list-tile-title>{{row.name_module}}</v-list-tile-title>
                                        </v-list-tile>

                                    </div>

                                </v-list-group>

                                <v-list-tile v-if="row.children==null" :href="'#'+row.url_module">
                                    <v-list-tile-action>
                                        <v-icon>{{row.icon_module}}</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-title>{{row.name_module}}</v-list-tile-title>
                                </v-list-tile>

                            </div>

                            <v-list-tile href="<?php $this->url("cerrar", "acceso"); ?>">
                                <v-list-tile-action>
                                    <v-icon>power_settings_new</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-title>Cerrar sesión</v-list-tile-title>
                            </v-list-tile>
                            <!--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>-->
                        </v-list>
                    </v-navigation-drawer>
                </v-hover>
            </template>
            <div class="main-body" v-bind:class="{'sidenav-close':!sidenavopen}">
                    <router-view></router-view>
            </div>
    </div>
</template>
<script>
export default {
    name:'app',
    data: () => ({
      overlay:false,
      title_modulo:null,
      sidenavopen:"true",
      drawer: true,
        mini: true,
        right: null,
        rowsmodulos:[],
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
      listar_menu(){
        console.log("menu-rincipal-portada-index");
        let self = this;
        /*axios.get('list_modulos?view').then(function(response){
            console.log(response.data)
            self.rowsmodulos=response.data;
        });*/
    },
    mini_clickoutside(e){
      this.mini = !document.getElementById('mini').contains(e.target);
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
}
</script>

