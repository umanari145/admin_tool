
import Vue from 'vue'
import VueRouter from 'vue-router';
import csvlist from '../components/CsvListComponent.vue';
import login from '../components/LoginComponent.vue';

const routeList = [];

Vue.use(VueRouter)

routeList.push({
    path: '/',
    component:login, 
});

routeList.push({
    path: '/csvlist',
    component:csvlist, 
});

const router = new VueRouter({
    mode:'history',
    hash: false,
    routes:routeList
});

export default router;