<template>
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
</template>
<script>
export default {
    name:'Sidebar',
}
</script>
