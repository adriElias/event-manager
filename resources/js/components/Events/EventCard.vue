<template>
    <div class="event-card">
        <div class="event-content">
            <h2 class="event-title">{{ event.name }}</h2>
            <p class="event-description">{{ event.description }}</p>
            <p class="event-location">{{ event.location }}</p>
            <button class="event-action" @click="verDetalles">Ver Detalles</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'EventCard',
    props: {
        event: {
            type: Object,
            required: true
        }
    },
    methods: {
        //redirige a la ruta de event-detail y pasamos el parametro de ruta id del event.id
        verDetalles() {
            this.$router.push({ name: 'event-detail', params: { id: this.event.id } });
        }
    }
}
</script>

<style scoped>
.event-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    max-width: 370px;
    box-shadow: 0 6px 24px rgba(25, 118, 210, 0.10), 0 1.5px 4px rgba(0,0,0,0.04);
    background: linear-gradient(135deg, #f5faff 0%, #e3f0ff 100%);
    display: flex;
    flex-direction: column;
    transition: box-shadow 0.2s;
}
.event-card:hover {
    box-shadow: 0 10px 32px rgba(25, 118, 210, 0.18), 0 2px 8px rgba(0,0,0,0.08);
}

.event-content {
    padding: 28px 24px 24px 24px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.event-title {
    margin: 0 0 10px 0;
    font-size: 1.5em;
    font-weight: 700;
    color: #1976d2;
    letter-spacing: 0.5px;
}

.event-description {
    margin-bottom: 10px;
    color: #333;
    font-size: 1.05em;
    line-height: 1.5;
}

.event-location {
    color: #1976d2;
    background: #e3f0ff;
    font-size: 1em;
    margin-bottom: 18px;
    padding: 4px 12px;
    border-radius: 12px;
    font-weight: 500;
}

.event-action {
    background: linear-gradient(90deg, #1976d2 60%, #42a5f5 100%);
    color: #fff;
    border: none;
    padding: 10px 28px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    font-size: 1em;
    box-shadow: 0 2px 8px rgba(25, 118, 210, 0.10);
    transition: background 0.2stylex-shadow 0.2s;
    outline: none;
}
.event-action:hover {
    background: linear-gradient(90deg, #1565c0 60%, #1976d2 100%);
    box-shadow: 0 4px 16px rgba(25, 118, 210, 0.18);
}
</style>
