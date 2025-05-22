<template>
    <Navbar />
    <form @submit.prevent="editarEvento" class="event-form">
        <h2>Editar Evento</h2>
        <div class="form-group">
            <label for="name">Nombre del Evento:</label>
            <input type="text" id="name" v-model="event.name" required />
        </div>

        <div class="form-group">
            <label for="time_date_start">Fecha y Hora de Inicio:</label>
            <input type="datetime-local" id="time_date_start" v-model="event.time_date_start" required />
        </div>

        <div class="form-group">
            <label for="time_date_end">Fecha y Hora de Fin:</label>
            <input type="datetime-local" id="time_date_end" v-model="event.time_date_end" required />
        </div>

        <div class="form-group">
            <label for="description">Descripción:</label>
            <textarea id="description" v-model="event.description" required></textarea>
        </div>

        <div class="form-group">
            <label for="location">Ubicación:</label>
            <input type="text" id="location" v-model="event.location" required />
        </div>

        <div class="form-group">
            <label for="directions">Indicaciones:</label>
            <textarea id="directions" v-model="event.directions"></textarea>
        </div>


        <button type="submit" class="submit-btn">Editar Evento</button>
        <p v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</p>
        <p v-if="successMessage" class="text-success mt-2">{{ successMessage }}</p> <!-- Mensaje de error -->
    </form>
    
</template>

<script>
export default {
    name: 'EditEvent',
    data() {
        return {
            event: {
                name: '',
                //utilizamos el método slice para cortar del 0-10 y solo quedarnos con la fecha y quitar la hora '2025-05-20T15:17:36.922Z'
                creation_date: new Date().toISOString().slice(0, 10),
                time_date_start: '',
                time_date_end: '',
                description: '',
                location: '',
                directions: '',
                created_by: ''
            },

            errorMessage: "",
            successMessage: ""
        };
    },
    async mounted() {
        //obtenemos el ID desde la URL
        const id = this.$route.params.id;
        //hacemos una petición del tipo GET a la ruta api/events/id e incluimos un token de autenticación guardado en el localStorage
        const response = await axios.get('/api/events/' + id, { headers: { Authorization: localStorage.getItem('token') } });
        //guardamos los datos e
        this.event = response.data;
    },
    methods: {
        async editarEvento() {

            this.errorMessage = '';
            try {
                const id = this.$route.params.id;
                //guardamos la respuesta de la petición del tipo PUT a la ruta /api/event
                //la petición la recibe el EventController
                const response = await axios.put('/api/event/' + id, {
                    name: this.event.name,
                    creation_date: this.event.creation_date,
                    time_date_start: this.event.time_date_start,
                    time_date_end: this.event.time_date_end,
                    description: this.event.description,
                    location: this.event.location,
                    directions: this.event.directions

                }, { headers: {
                    Authorization: localStorage.getItem('token') 
                }});
                //si el registro es correcto, guardaremos el mensaje en el successMessage
                //si hay successMessage se mostrará el mensaje
                this.successMessage = response.data.message;

                // //Esperamos 3s
                // await new Promise(resolve => setTimeout(resolve, 3000));
                // //Mostramos el form Login
                // this.$emit('show-event-card');

                // console.log(response.data);

                //Entramos al catch si falla la validación de los datos
            } catch (error) {
                this.errorMessage = 'No autorizado o error al editar el evento.';

                console.log(error);
            }

        }
    }
};
</script>

<style scoped>
.event-form {
    max-width: 500px;
    margin: 2rem auto;
    padding: 2rem 2.5rem;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.event-form h2 {
    text-align: center;
    margin-bottom: 1rem;
    color: #2c3e50;
    font-weight: 700;
    letter-spacing: 1px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

label {
    font-weight: 600;
    color: #34495e;
}

input,
textarea {
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 0.75rem;
    font-size: 1rem;
    transition: border-color 0.2s;
    background: #f9fafb;
    outline: none;
}

input:focus,
textarea:focus {
    border-color: #6366f1;
    background: #fff;
}

textarea {
    min-height: 80px;
    resize: vertical;
}

.submit-btn {
    background: linear-gradient(90deg, #6366f1 0%, #60a5fa 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    align-self: center;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.08);
    transition: background 0.2s, transform 0.1s;
}

.submit-btn:hover {
    background: linear-gradient(90deg, #4f46e5 0%, #2563eb 100%);
    transform: translateY(-2px) scale(1.03);
}
</style>