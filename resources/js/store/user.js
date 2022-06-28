
import axios from 'axios';

const user = {
    namespaced: true,
    state: {
      name: null,
      access_token:null
    },
    getters:{
        getAccessToken(state) {
            return state.access_token;;
        }
    },
    //setter
    mutations: {
        setToken(state, access_token){
            if (access_token !== undefined) {
                state.access_token = access_token
            }
        },
        clearLogin(state) {
            state.access_token = null
        }
    },
    actions: {
    }

};

export default user;