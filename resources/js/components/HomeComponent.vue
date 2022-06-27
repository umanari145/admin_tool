<template>
    <div>
        <BasicHome>homeです</BasicHome>
        <Loading ref="child"></Loading>
    </div>
</template>

<script>
import BasicHome from "../components/Layout/BasicHome";
import {headers} from "../components/const.js";
import Loading from "../components/LoadingComponent";
import masterJson from "../config/master.json";

export default {
    name:'home',
    components:{
        BasicHome,
        Loading
    },
    methods:{
        getComanyList() {
            let url = '/api/company';
            // 単純なメソッドの呼び出しはこれ
            this.$refs.child.loadingOn();
            axios.get(url, {headers: this.getHeaderIncToken(headers)})
                .then((res) => {
                    if (res['status'] === 200) {
                        let companyData = res['data']['data'];
                        this.$store.commit("master/setMaster", {key:'company', value:companyData});
                    } else {
                        alert("データの取得に失敗しました。");
                    }
                })
                .finally(() => {
                    this.$refs.child.loadingOff();
                })
        },
        getHeaderIncToken(headers) {
            headers['Authorization'] = 'Bearer ' + this.$store.getters['user/getAccessToken'];
            return headers;
        },
        getMasterJson(){
            for(let key in masterJson) {
                this.$store.commit("master/setMaster", {key:key, value:masterJson[key]});
            }
        }
    },
    created() {
    },
    mounted() {
        this.getComanyList();
        this.getMasterJson();
    },
    data() {
        return {
        }
    }
}
</script>
