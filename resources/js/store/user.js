
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
        },
        getAuthCheck(state) {
            const headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + state.access_token
            };
            return axios.get('api/check', {headers:headers});
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