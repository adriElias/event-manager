<template>
  <div class="p-4">
    <h1>{{ this.location }}</h1>

    <div v-if="coordenadas">
      <p class="mt-4">Latitud: {{ coordenadas.lat }}</p>
      <p>Longitud: {{ coordenadas.lon }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    location: {
      type: String,
    }
  },
  data() {
    return {
      coordenadas: null
    };
  },
  methods: {
  },
  async mounted() {
    try {
      console.log('AQUI L ALOCATION', this.location)
      //Hacemos la peticipión a nominatim
      //Geocoding nos convierte una dirección normal en coordenadas
      const response = await axios.get('https://nominatim.openstreetmap.org/search', {
        params: {
          q: this.location,
          format: 'json',
          limit: 1
        },
        headers: {
          'Accept-Language': 'es', // Idioma de los resultados
        }
      });

      if (response.data.length > 0) {
        this.coordenadas = response.data[0];
      } else {
        alert('Dirección no encontrada');
      }
    } catch (error) {
      // No funcina hubo un problema, la location queda con undefined
      console.error('Error en geocoding:', error);
      alert('Hubo un problema al buscar la dirección');
    }
  }

};
</script>
