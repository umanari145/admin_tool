
const user = {
    namespaced: true,
    state: {
      name: null,
      access_token:null,
      isLogin : true
    },
    getters:{
        getAccessToken(state) {
            return state.access_token;
        }
    },
    //setter
    mutations: {
        setToken(state, access_token){
            if (access_token !== undefined) {
                state.access_token = access_token
                state.isLogin = true;
            }
        },
        clearLogin(state) {
            state.isLogin = false;
        }
    }
};

export default user;