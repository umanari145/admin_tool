<template>
    <div>
        <BasicHome>homeです</BasicHome>
        <Loading ref="child"></Loading>
    </div>
</template>

<script>
import BasicHome from "../components/Layout/BasicHome";
import masterJson from "../config/master.json";
import Loading from "../components/LoadingComponent";
import HttpHelper from "./Repository/HttpHelper";

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
            const httpHelper = new HttpHelper();
            httpHelper.get(url)
                .then((res) => {
                    if (res['status'] === 200) {
                        let companyData = res['data']['data'];
                        this.$store.commit("master/setMaster", {key:'company', value:companyData});
                    } else {
                        alert("データの取得に失敗しました。");
                    }
                }).
                catch((err) => {
                    httpHelper.errorHandling(err);
                })
                .finally(() => {
                    this.$refs.child.loadingOff();
                })
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
