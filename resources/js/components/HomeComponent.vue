<template>
    <div>
        <Sidebar></Sidebar>
        <div class="wrapper main-wrapper d-flex flex-column min-vh-100 bg-light ">
            <Header></Header>
            <div class="body flex-grow-1 px-3">
                <div class="container-lg">
                </div>
            </div>
            <Footer></Footer>
        </div>
    </div>
</template>

<script>
import Header from "../components/Layout/Header";
import Sidebar from "../components/Layout/Sidebar";
import Footer from "../components/Layout/Footer";

export default {
    name:'home',
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