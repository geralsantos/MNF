Vue.use(VueRouter)
import portada_index from "../componentes/portada/portada-index.vue";
import ta_listado_vuelos from "../componentes/tuua_application/ta_listado_vuelos.vue";
import ta_listado_pax from "../componentes/tuua_application/ta_listado_pax.vue";
import login from "../componentes/login/login.vue";

  const router = new VueRouter({
    mode:'history',
    routes: [
      { path: '/MNF/portada/index',component: portada_index },
      { path: '/MNF/tuua_application/ta_listado_vuelos', component: ta_listado_vuelos },
      { path: '/MNF/tuua_application/ta_listado_pax', component: ta_listado_pax },
      { path: '/MNF/acceso/index', component: login },
    ]
});
export default router;