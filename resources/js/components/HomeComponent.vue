<template>
    <div class="container">
        <div class="row justify-content-center">
            <div @click="logout">ログアウト</div>
            <router-link to="/csvlist">CSV</router-link>
            home
        </div>
    </div>
</template>

<script>

export default {
    name:'home',
    methods:{
        logout() {
            this.$store.commit("user/clearLogin");
            this.$router.push('/login');
        }
    },
    created() {
    },
    data() {
        return {
        }
    }
}
</script>
<style type="text/css">

</style>