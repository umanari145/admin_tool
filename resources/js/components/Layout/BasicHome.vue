<template>
    <div>
        <Sidebar></Sidebar>
        <div class="wrapper main-wrapper d-flex flex-column min-vh-100 bg-light ">
            <Header></Header>
            <div class="body flex-grow-1 px-3">
                <div class="container-lg">
                    <slot></slot>
                </div>
            </div>
            <Footer></Footer>
        </div>
    </div>
</template>

<script>
import Header from "./Header";
import Sidebar from "./Sidebar";
import Footer from "./Footer";

export default {
    name:'BasicHome',
    components:{
        Header,
        Sidebar,
        Footer
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
.main-wrapper {
    padding-left: var(--cui-sidebar-occupy-start, 0);
}
</style>