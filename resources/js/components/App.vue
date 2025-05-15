<template>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Bienvenido</h2>

        <div class="text-center mb-4">
            <button class="btn btn-outline-primary me-2" @click="formulario = 'login'">
                Iniciar sesión
            </button>
            <button class="btn btn-primary" @click="formulario = 'registro'">
                Registrarse
            </button>
        </div>

        <div v-if="formulario === 'login'" class="card p-4">
            <h4>Login</h4>
            <form @submit.prevent="enviarLogin">
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" v-model="login.email" required />
                </div>
                <div class="mb-3">
                    <label>Contraseña</label>
                    <input type="password" class="form-control" v-model="login.password" required />
                </div>
                <button class="btn btn-success">Entrar</button>
            </form>
        </div>

        <div v-if="formulario === 'registro'" class="card p-4">
            <h4>Registro</h4>
            <form @submit.prevent="enviarRegistro">
                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" class="form-control" v-model="registro.name" required />
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" v-model="registro.email" required />
                </div>
                <div class="mb-3">
                    <label>Contraseña</label>
                    <input type="password" class="form-control" v-model="registro.password" required />
                </div>
                <div class="mb-3">
                    <label>Confirmar contraseña</label>
                    <input type="password" class="form-control" v-model="registro.password_confirmation" required />
                </div>
                <button class="btn btn-primary">Registrarse</button>
                <p v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</p> <!-- Mensaje de error -->


            </form>

            <p v-if="successMessage" class="text-success mt-2">{{ successMessage }}</p> <!-- Mensaje de error -->

        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            formulario: "registro", // o 'registro'
            login: {
                email: "",
                password: "",
            },
            registro: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
            },
            errorMessage: "",
            successMessage: ""
        };
    },
    methods: {
        enviarLogin() {
            // Aquí puedes usar axios para enviar login a tu backend Laravel
            alert(`Login: ${this.login.email}`);
        },
        async enviarRegistro() {
            this.errorMessage = '';
            try {
                const response = await axios.post('/api/register', {
                    name: this.registro.name,
                    email: this.registro.email,
                    password: this.registro.password,
                    password_confirmation: this.registro.password_confirmation,
                });

                this.successMessage = response.data.message;

                await new Promise(resolve => setTimeout(resolve, 2000));

                this.formulario = "login"

                console.log(response.data);
            } catch (error) {
                console.log(error);
                const validationErrors = error.response.data.errors;

                if (validationErrors.password) {
                    this.errorMessage = validationErrors.password[0];
                }
                if (validationErrors.name) {
                    this.errorMessage = validationErrors.name[0];
                }
            }
        },

    },
};
</script>

<style scoped>
.card {
    max-width: 500px;
    margin: 0 auto;
}
</style>
