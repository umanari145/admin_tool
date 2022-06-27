
const master = {
    namespaced: true,
    state: {
        name: null,
        master: {
            company:{},
            is_required:{},
            csv_category:{}
        }
    },
    getters:{
        getMaster(state) {
            return state.master;
        }
    },
    //setter
    mutations: {
        setMaster(state, {key, value}){
            state.master[key] = value;
        }
    }
};

export default master;