
const user = {
    namespaced: true,
    state: {
      name: null,
      isLogin : true
    },
    getters:{
        getLoginInfo(state) {
            return state.isLogin;
        }
    },
    //setter
    mutations: {
        setLogin(state, user_info){
            if (user_info['user_code'] === 'aaaa' &&
            user_info['password'] === '0000'
            ) {
                state.isLogin = true;
            }
        },
        clearLogin(state) {
            state.isLogin = false;
        }
    }
};

export default user;