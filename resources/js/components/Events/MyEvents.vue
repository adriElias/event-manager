<template>
    <Navbar/>
    <h1>Mis Eventos</h1>
    <!-- estamos iterando por los eventos que esta enviando el backend -->
    <div v-for="event in events" class="container">
        <!-- mostramos el  componente eventCard y le pasamos la información del evento -->
        <EventCard :event="event" />
    </div>
    <div v-if="events.length === 0 && userTypeId == 1" class="list-group-item text-center text-muted">
        No estas apuntado a ningún evento.
    </div>
    <div v-if="events.length === 0 && userTypeId == 2" class="list-group-item text-center text-muted">
        No tienes ningún evento creado.
    </div>
</template>

<script>

export default {
    name: 'MyEvents',
    data() {
        return {
            events: [],
            userTypeId:""
        };
    },
    //función del ciclo de vida de un componente que se ejecuta después de que el componente ha sido insertado en el DOM
    async mounted() {
       //obtenemos todos los eventos haciendo una petición GET a la ruta api/events, enviando el token de autenticación en el  header authorization
       //el token se ha generado al iniciar sesión y se ha guardado en el localStorage 
       //hay que poner await para esperar que el backend responda
        const response = await axios.get('/api/my-events', { headers: { Authorization: localStorage.getItem('token') } });
        //Guardamos los eventos que devuelve la API en el data del componente para poder mostrarlos por pantalla
        this.events = response.data;
        this.userTypeId = localStorage.getItem('userTypeId');
    },
    methods: {
    }
};
</script>

<style scoped>
/* Estilos para tu componente */
h1 {
    margin-top: 32px;
    text-align: center;
    font-size: 2.2rem;
    color: #2c3e50;
    letter-spacing: 1px;
    font-weight: 700;
}

.container {
    display: flex;
    flex-direction: column;
    gap: 24px; /* Espacio entre las cards */
    flex-wrap: wrap; /* Opcional, para que bajen si no caben */
    margin: 0 auto;
    margin-top: 24px;
    max-width: 600px;
    background: #f8f9fa;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(44, 62, 80, 0.08);
    padding: 24px 32px;
    transition: box-shadow 0.2s;
}

.container:hover {
    box-shadow: 0 8px 24px rgba(44, 62, 80, 0.15);
}

@media (max-width: 700px) {
    .container {
        max-width: 98vw;
        padding: 16px 6vw;
    }
    h1 {
        font-size: 1.5rem;
    }
}
</style>