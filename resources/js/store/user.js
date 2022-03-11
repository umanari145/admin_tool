
const user = {
    state: {
      name: null,
      isLogin : false
    },
    getters:{
        getLoginInfo(state) {
            return state.isLogin;
        }
    }
};

export default user;