<template>
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
</template>
<script>
export default {
    name:'Header',
    methods:{
        logout() {
            this.$store.commit("user/clearLogin");
            this.$router.push('/login');
        }
    }
}
</script>