<template>
    <div class="container">
        <div>
            <label for="userCode">ユーザーコード</label>
            <input type="text" v-model="user.user_code">
        </div>
        <div>
            <label for="password">パスワード</label>
            <input type="password" v-model="user.password">
        </div>
        <div class="text-danger" v-show="errorMessage !='' ">
            {{errorMessage}}
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
            this.errorMessage = '';

            this.$store.commit("user/setLogin", {
                'user_code':this.user.user_code,
                'password':this.user.password                
            })

            if (this.$store.getters['user/getLoginInfo'] === true) {
                this.$router.push('/');
            } else {
                this.errorMessage = 'ユーザーかパスワードが間違っています。';
            }
        }
    },
    created() {
    },
    data() {
        return {
            user:{
                'user_code':'',
                'password':''
            },
            errorMessage:''
        }
    }
}
</script>
<style type="text/css">

</style>