
require('./bootstrap');

window.Vue = require('vue');

import VModal from 'vue-js-modal';

Vue.component('Loading', require('./components/LoadingComponent.vue').default);

import router from './router';

Vue.use(VModal);
//console.log(router);

const app = new Vue({
    el: '#app',
    router
});

//app.use(router);
