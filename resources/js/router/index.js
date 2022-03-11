
import Vue from 'vue'
import VueRouter from 'vue-router';
import csvlist from '../components/CsvListComponent.vue';
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
    path: '/csvlist',
    component:csvlist, 
    meta:{requireAuth:true}
});

const router = new VueRouter({
    mode:'history',
    hash: false,
    routes:routeList
});

let isLogin = store.getters.getLoginInfo;

// routing
router.beforeEach((to, from, next) => {
    console.log(to);
    // 認証が必要なページ
    if (to.matched.some(record => record.meta.requireAuth)) {
        console.log(isLogin);
        if (!isLogin) {
            console.log(isLogin)
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