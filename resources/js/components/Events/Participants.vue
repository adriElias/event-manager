<template>
    <Navbar/>
    <div class="card shadow">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="mb-0 title">
                <i class="fas fa-users me-2 accent"></i>
                Lista de Participantes
            </h3>
        </div>
        <ul class="list-group list-group-flush">

        <!-- en vue se necesita pasar una :key en el v-for para poder identificarlo y así optimizar el renderizado y actualización de manera interna-->
            <li v-for="participant in participants" :key="participant.id" class="list-group-item d-flex align-items-center" >
                <div class="avatar me-3">
                    <!-- coge la inicial del nombre del participante y ponerla en Mayúscula -->
                    <span>{{ participant.name.charAt(0).toUpperCase() }}</span>
                </div>
                <div>
                    <div class="name">{{ participant.name }}</div>
                    <div class="email">{{ participant.email }}</div>
                </div>
            </li>
            <li v-if="participants.length === 0" class="list-group-item text-center text-muted">
                No hay participantes registrados.
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "Participants",
    data() {
        return {
            participants: []
        };
    },
    async mounted() {
        const id = this.$route.params.id;
        const response = await axios.get('/api/events/' + id + '/participants', {
            headers: { Authorization: localStorage.getItem('token') }
        });
        this.participants = response.data.participants;
    }
};
</script>

<style scoped>
.card {
    max-width: 420px;
    margin: 32px auto;
    border: none;
    border-radius: 18px;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.10);
    background: linear-gradient(135deg, #f8fafc 0%, #e0e7ef 100%);
    overflow: hidden;
}

.card-header {
    background: linear-gradient(90deg, #4f8cff 0%, #6ed6ff 100%);
    padding: 20px 24px;
    border-bottom: none;
}

.title {
    color: #fff;
    font-weight: 700;
    font-size: 1.3rem;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
}

.accent {
    color: #fff;
    font-size: 1.2em;
}

.list-group-item {
    padding: 18px 24px;
    border-bottom: 1px solid #e3e8ee;
    background: transparent;
    transition: background 0.2s;
    display: flex;
    align-items: center;
}

.list-group-item:last-child {
    border-bottom: none;
}

.avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #6ed6ff 0%, #4f8cff 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: bold;
    font-size: 1.1rem;
    box-shadow: 0 2px 8px rgba(79, 140, 255, 0.15);
}

.name {
    font-weight: 600;
    color: #22223b;
    font-size: 1.05rem;
}

.email {
    color: #6c757d;
    font-size: 0.95rem;
}

.text-muted {
    color: #b0b8c1 !important;
}
</style>