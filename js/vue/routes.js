Vue.use(VueRouter)

import portada_index from "../componentes/portada/portada-index.vue";
import tuua_application from "../componentes/tuua_application/ta_listado_vuelos.vue";
import login from "../componentes/login/login.vue";

  const router = new VueRouter({
    mode:'history',
    routes: [
      { path: '/MNF/portada/index',component: portada_index },
      { path: '/MNF/tuua_application/ta_listado_vuelos', component: tuua_application },
      { path: '/MNF/acceso/index', component: login },

    ]
});
export default router;