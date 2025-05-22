<template>
  <nav class="navbar custom-navbar navbar-expand-lg">
    <div class="container custom-container">
      <router-link class="navbar-brand custom-brand" to="/home">Inicio</router-link>
      <div class="navbar-links" v-if="isLogged">
        <router-link class="nav-link custom-link" to="/my-events">Mis eventos</router-link>
        <router-link v-if="rol === 'org'" class="nav-link custom-link" to="/create-event">Crear Evento</router-link>
        <router-link v-if="rol === 'vol'" class="nav-link custom-link" to="/explore-events">Explora eventos</router-link>
      </div>
      <div class="ml-auto" v-if="isLogged">
        <button class="btn btn-outline-light custom-logout" @click="logout">
          <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </button>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: "Navbar",
  data() {
    return {
      isLogged: false,
      rol: null
    };
  },
  mounted() {
    if(localStorage.getItem("token")) {
      this.isLogged = true
    } else {
      this.isLogged = false
    }


    if(localStorage.getItem("userTypeId") == 2) {
      this.rol = 'org'
    } else {
      this.rol = 'vol'
    }

  },
  methods: {
    logout() {
      localStorage.removeItem('token');
      localStorage.removeItem('userTypeId');
      this.$router.push({ name: 'welcome' });
    }
  }
};
</script>

<style scoped>
.custom-navbar {
  background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  padding: 0.7rem 0;
}

.custom-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.custom-brand {
  font-size: 1.7rem;
  font-weight: bold;
  color: #fff !important;
  letter-spacing: 1px;
  transition: color 0.2s;
}

.custom-brand:hover {
  color: #ffd700 !important;
}

.navbar-links {
  display: flex;
  gap: 1.2rem;
}

.custom-link {
  color: #fff !important;
  font-size: 1.1rem;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  transition: background 0.2s, color 0.2s;
  font-weight: 500;
}

.custom-link:hover {
  background: rgba(255, 255, 255, 0.15);
  color: #ffd700 !important;
  text-decoration: none;
}

.custom-logout {
  border-radius: 20px;
  font-weight: 500;
  border: 2px solid #fff;
  color: #fff;
  transition: background 0.2s, color 0.2s;
}

.custom-logout:hover {
  background: #fff;
  color: #2575fc;
  border-color: #fff;
}
</style>
