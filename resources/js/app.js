
require('./bootstrap');

window.Vue = require('vue');

Vue.component('csvlist-component', require('./components/CsvListComponent.vue').default);
Vue.component('Loading', require('./components/LoadingComponent.vue').default);

const app = new Vue({
    el: '#app',
});
