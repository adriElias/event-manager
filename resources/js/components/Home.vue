<script>
import HomeOrg from './HomeOrg.vue';
import HomeVolunteer from './HomeVolunteer.vue';
import Navbar from './Navbar.vue';



export default {
    name: "Home",
    data() {
        return {
            //recuperamos el userTyperId del localStorage
            userTypeId: localStorage.getItem("userTypeId")
        };
    },
};

</script>

<style></style>
<!-- En este componente mostramos el componente segun su rol -->
<template>
    <Navbar/>
    <div v-if="userTypeId == 1">
        <HomeVolunteer />
    </div>
    <div v-else-if="userTypeId == 2">
        <HomeOrg />
    </div>

</template>
