
require('./bootstrap');

window.Vue = require('vue');

import VModal from 'vue-js-modal';

Vue.component('csvlist-component', require('./components/CsvListComponent.vue').default);
Vue.component('Loading', require('./components/LoadingComponent.vue').default);

Vue.use(VModal);

const app = new Vue({
    el: '#app',
});
