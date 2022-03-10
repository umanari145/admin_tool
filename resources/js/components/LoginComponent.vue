<template>
    <div class="container">
        <div>
            <label for="userCode">ユーザーコード</label>
            <input type="text" v-model="user.userCode">
        </div>
        <div>
            <label for="password">パスワード</label>
            <input type="text" v-model="user.password">
        </div>
        <div>
            <button @click="doLogin">Sign In</button>
        </div>
    </div>
</template>

<script>

import Modal from "../components/LoginComponent";
import Loading from "../components/LoadingComponent";

export default {
    name:'login',
    components:{
        Loading
    },
    methods:{
        doLogin() {

        }
    },
    created() {
    },
    data() {
        return {
            user:{
                'user_code':'',
                'passoword':''
            }
        }
    }
}
</script>
<style type="text/css">

</style>