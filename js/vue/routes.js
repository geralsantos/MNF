Vue.use(VueRouter)

import portada_index from "../componentes/portada/portada-index.vue";
import tuua_application from "../componentes/tuua_application/tuua_application.vue";
  const router = new VueRouter({
    mode:'history',
    routes: [
      { path: '/MNF/portada/index',component: portada_index },
      { path: '/MNF/tuua_application/index', component: tuua_application },
    ]
});
export default router;