
import Vue from 'vue'
import VueRouter from 'vue-router';
import home from '../components/HomeComponent.vue';
import csvlist from '../components/CsvListComponent.vue';
import handylist from '../components/HandyListComponent.vue';
import login from '../components/LoginComponent.vue';
import store from '../store';

const routeList = [];

Vue.use(VueRouter)

routeList.push({
    path: '/login',
    component:login, 
    meta:{requireAuth:false}
});

routeList.push({
    path: '/',
    component:home,
    meta:{requireAuth:true}
});

routeList.push({
    path: '/csv',
    component:csvlist, 
    meta:{requireAuth:true}
});

routeList.push({
    path: '/handy',
    component:handylist, 
    meta:{requireAuth:true}
});

const router = new VueRouter({
    mode:'history',
    hash: false,
    routes:routeList
});

// routing
router.beforeEach((to, from, next) => {
    let isLogin = store.getters['user/getAccessToken'];

    // 認証が必要なページ
    if (to.matched.some(record => record.meta.requireAuth)) {
        if (!isLogin) {
            // 未ログインならログインページへ
            next('/login')
        } else {
            next() // ログインしている場合はそのまま
        }
    } else {
        // 認証が必要じゃないページ場合はそのまま
        next()
    }
})  

export default router;