import Vue from 'vue';
import Vuex from 'vuex';
import user from './user.js';

Vue.use(Vuex);

const  module = {
    modules:{
        user
    }
}

export default new Vuex.Store(module);


