<template>
    <div>
        <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
            <div class="sidebar-brand d-none d-md-flex">
            </div>
            <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
                <li class="nav-title pt-0">Menu</li>
                <li class="nav-item"><a class="nav-link" href="colors.html">
                    <img class="nav-icon" src="icons/svg/free/cil-home.svg" alt="home">
                    Companies</a></li>
                <li class="nav-item"><router-link class="nav-link" to="/csvlist">
                    <img class="nav-icon" src="icons/svg/free/cil-list.svg" alt="list">
                    CsvList</router-link></li>
            </ul>
            <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
        </div>
        <div class="wrapper main-wrapper d-flex flex-column min-vh-100 bg-light ">
            <header class="header header-sticky mb-4">
                <div class="container-fluid">
                <div class="d-flex">
                    <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                        <img class="icon icon-lg" src="icons/svg/free/cil-menu.svg" alt="menu">
                    </button>
                    <ul class="header-nav d-none d-md-flex">
                        <li class="nav-item"><a class="nav-link" href="#">Companies</a></li>
                        <li class="nav-item"><router-link to="csvList" class="nav-link" href="#">CsvList</router-link></li>
                    </ul>
                </div>
                
                <a class="header-brand d-md-none" href="#">
                    <svg width="118" height="46" alt="CoreUI Logo">
                    <use xlink:href="assets/brand/coreui.svg#full"></use>
                    </svg></a>
                
                <ul class="header-nav ms-3">
                    <li class="nav-item">
                        <img class="icon-lg icon" style="cursor:pointer;" @click="logout" src="icons/svg/free/cil-account-logout.svg" alt="logout">
                    </li>
                </ul>
                </div>
            </header>
            <div class="body flex-grow-1 px-3">
                <div class="container-lg">
                </div>
            </div>
            <footer class="footer">
            </footer>
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
.main-wrapper {
    padding-left: var(--cui-sidebar-occupy-start, 0);
}
</style>