<template>
    <Navbar/>
    <h1>Volunteer</h1>
    <!-- estamos iterando por los eventos que esta enviando el backend -->
    <div v-for="event in events" class="container">
        <!-- mostramos el  componente eventCard y le pasamos la información del evento -->

        <!-- pasamos el evento como propiedad al EevntCard -->
        <EventCard :event="event" />
    </div>
</template>

<script>
import EventCard from './EventCard.vue';



export default {
    name: 'HomeVolunteer',
    data() {
        return {
            events: []
        };
    },
    //función del ciclo de vida de un componente que se ejecuta después de que el componente ha sido insertado en el DOM
    async mounted() {
       //obtenemos todos los eventos haciendo una petición GET a la ruta api/events, enviando el token de autenticación en el  header authorization
       //el token se ha generado al iniciar sesión y se ha guardado en el localStorage 
       //hay que poner await para esperar que el backend responda
        const response = await axios.get('/api/events', { headers: { Authorization: localStorage.getItem('token') } });
        //Guardamos los eventos que devuelve la API en el data del componente para poder mostrarlos por pantalla
        this.events = response.data;
    },
    methods: {
    }
};
</script>

<style scoped>
div {
    display: flex;
    flex-direction: column;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 20px;
}
</style>