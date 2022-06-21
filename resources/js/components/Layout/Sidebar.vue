<template>
    <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
        <div class="sidebar-brand d-none d-md-flex">
        </div>
        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
            <li class="nav-title pt-0">Menu</li>
            <li class="nav-item"><router-link class="nav-link" to="/handy">
                <img class="nav-icon" src="icons/svg/free/cil-tablet.svg" alt="home">
                Handies</router-link></li>
            <li class="nav-item"><router-link class="nav-link" to="/csv">
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
