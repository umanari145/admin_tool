<template>
    <div>
        <div class="loading_bg" v-show="isLoading">
            <img src="/img/loading.gif">
        </div>
    </div>
</template>
<script>

export default {
    name:'loading',
    methods:{
        loadingOn() {
            this.isLoading = 1;
        },
        loadingOff() {
            this.isLoading = 0;
        },
    },
    data() {
        return {
            isLoading:0
        }
    }
}
</script>
<style type="text/css">
.loading_bg {
    position:absolute;
    top:0;
    left:0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    background-color:#fff;
    opacity: 0.6;
}

.loading_bg img{
    position: absolute;
    top:50%;
    left:50%;
    margin-left:-130px;
    margin-top:-130px;
}
</style>