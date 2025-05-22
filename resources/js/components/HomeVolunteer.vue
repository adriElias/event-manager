<template>
    <div class="home-org-container">
        <img 
            src="../../public/portada.jpg" 
            alt="Evento de voluntariado" 
            class="home-org-image"
        >
        <div class="home-org-overlay">
            ¡Bienvenidx! Utiliza esta herramienta para apuntarte a diferentes voluntariados
        </div>
    </div>
</template>

<script>
export default {
    name: 'HomeOrg',
    data() {
        return {
        };
    },
    methods: {
    }
};
</script>

<style scoped>
.home-org-container {
    position: relative;
    display: inline-block;
}

.home-org-image {
    max-width: 100%;
    height: auto;
}

.home-org-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    background: rgba(0,0,0,0.5);
    padding: 16px 32px;
    border-radius: 8px;
    font-size: 2rem;
    text-align: center;
}
</style>