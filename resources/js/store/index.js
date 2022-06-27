import Vue from 'vue';
import Vuex from 'vuex';
import user from './user.js';
import master from './master.js';

Vue.use(Vuex);

const  module = {
    modules:{
        user,
        master
    }
}

export default new Vuex.Store(module);


