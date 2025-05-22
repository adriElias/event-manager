<template>
    <Navbar />
    <div class="event-container">
        <div class="event-header">
            <img v-if="event.image" :src="event.image" alt="Imagen del evento" class="event-image" />
            <h1 class="event-title">{{ event.name }}</h1>
        </div>
        <div class="event-details card">
            <h2 class="section-title">Detalles del Evento</h2>
            <div class="details-list">
                <div class="detail-item">
                    <span class="detail-label">Fecha de creación:</span>
                    <span class="detail-value">{{ event.creation_date }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Inicio:</span>
                    <span class="detail-value">{{ event.time_date_start }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Fin:</span>
                    <span class="detail-value">{{ event.time_date_end }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Descripción:</span>
                    <span class="detail-value">{{ event.description }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Ubicación:</span>
                    <span class="detail-value">{{ event.location }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Indicaciones:</span>
                    <span class="detail-value">{{ event.directions }}</span>
                </div>
            </div>
            <div class="actions" v-if="rol == 'vol'">
                <button @click="joinEvent" class="btn primary">Unirse al evento</button>
                <button @click="leaveEvent" class="btn danger">Desapuntarme</button>
            </div>
            <div class="actions" v-if="rol == 'org'">
                <button @click="editEvent" class="btn primary">Editar evento</button>
                <button @click="" class="btn secondary">Ver participantes</button>
                <button @click="deleteEvent" class="btn danger">Eliminar evento</button>
            </div>
            <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Event',
    data() {
        return {
            event: {},
            errorMessage: "",
            rol: this.getRol()
        };
    },
    async mounted() {
        const id = this.$route.params.id;
        const response = await axios.get('/api/events/' + id, { headers: { Authorization: localStorage.getItem('token') } });
        this.event = response.data;
    },
    methods: {
        getRol: () => {
            if (localStorage.getItem("userTypeId") == 2) {
                return "org";
            } else {
                return "vol";
            }
        },
        editEvent() {
            this.$router.push({ name: 'edit-event', params: { id: this.event.id } });
        },
        async joinEvent() {
            const id = this.$route.params.id;
            try {
                await axios.post(`/api/events/${id}/join`, {}, { headers: { Authorization: localStorage.getItem('token') } });
                this.errorMessage = '';
                alert('Te has unido al evento.');
            } catch (error) {
                this.errorMessage = error.response.data.message;
                console.log(error);
            }
        },
        async leaveEvent() {
            const id = this.$route.params.id;
            try {
                await axios.post(`/api/events/${id}/leave`, {}, { headers: { Authorization: localStorage.getItem('token') } });
                this.errorMessage = '';
                alert('Te has desapuntado del evento.');
            } catch (error) {
                this.errorMessage = error.response.data.message;
                console.log(error);
            }
        },
        async deleteEvent(){
            const id = this.$route.params.id;
            try {
                await axios.delete(`/api/events/${id}`, { headers: { Authorization: localStorage.getItem('token') } });
                this.errorMessage = '';
                alert('Se ha eliminado el evento correctamente.');
                await new Promise(resolve => setTimeout(resolve, 3000));
                this.$router.push({ name: 'my-events' });
            } catch (error) {
                this.errorMessage = error.response.data.message;
                console.log(error);
            }
        }
    }
}
</script>

<style scoped>
.event-container {
    background: #f7f9fb;
    min-height: 100vh;
    padding: 40px 0;
}

.event-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 30px;
}

.event-image {
    width: 180px;
    height: 180px;
    object-fit: cover;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    margin-bottom: 20px;
    border: 4px solid #fff;
}

.event-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1976d2;
    margin-bottom: 0;
    text-align: center;
    letter-spacing: 1px;
}

.card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(25, 118, 210, 0.08);
    padding: 2rem 2.5rem;
    max-width: 600px;
    margin: 0 auto;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1976d2;
    margin-bottom: 1.5rem;
    text-align: center;
}

.details-list {
    margin-bottom: 2rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.detail-label {
    font-weight: 500;
    color: #555;
}

.detail-value {
    color: #222;
    max-width: 60%;
    text-align: right;
    word-break: break-word;
}

.actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.btn {
    padding: 0.6rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
    outline: none;
}

.btn.primary {
    background: #1976d2;
    color: #fff;
}

.btn.primary:hover {
    background: #1565c0;
}

.btn.secondary {
    background: #e3eafc;
    color: #1976d2;
}

.btn.secondary:hover {
    background: #bbd2fa;
}

.btn.danger {
    background: #e53935;
    color: #fff;
}

.btn.danger:hover {
    background: #b71c1c;
}

.error-message {
    color: #e53935;
    text-align: center;
    margin-top: 1rem;
    font-weight: 500;
}
</style>