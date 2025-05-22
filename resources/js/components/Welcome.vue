<template>
    <div class="container mt-5 welcome-bg">
        <h2 class="text-center mb-4 welcome-title">Bienvenido</h2>

        <div class="text-center mb-4">
            <button class="btn btn-outline-primary me-2 welcome-btn" :class="{ active: formulario === 'login' }" @click="formulario = 'login'">
                Iniciar sesión
            </button>
            <button class="btn btn-outline-primary welcome-btn" :class="{ active: formulario === 'registro' }" @click="formulario = 'registro'">
                Registrarse
            </button>
        </div>

        <transition name="fade">
        <div v-if="formulario === 'login'" class="card p-4 shadow welcome-card">
            <h4 class="mb-3 text-primary">Login</h4>
            <form @submit.prevent="enviarLogin">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" v-model="login.email" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-control" v-model="login.password" required />
                </div>
                <button class="btn btn-success w-100">Entrar</button>
                <p v-if="errorMessage" class="text-danger mt-2 text-center">{{ errorMessage }}</p> <!-- Mensaje de error -->
            </form>
        </div>
        </transition>

        <transition name="fade">
        <div v-if="formulario === 'registro'" class="card p-4 shadow welcome-card">
            <h4 class="mb-3 text-primary">Registro</h4>
            <form @submit.prevent="enviarRegistro">
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" v-model="registro.name" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" v-model="registro.email" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-control" v-model="registro.password" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirmar contraseña</label>
                    <input type="password" class="form-control" v-model="registro.password_confirmation" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipo de cuenta</label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="user" value="1"
                                v-model="registro.userTypeId" required>
                            <label class="form-check-label" for="rolUser">
                                Voluntarix
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="org" value="2"
                                v-model="registro.userTypeId" required>
                            <label class="form-check-label" for="rolOrg">
                                Organización
                            </label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary w-100">Registrarse</button>
                <p v-if="errorMessage" class="text-danger mt-2 text-center">{{ errorMessage }}</p> <!-- Mensaje de error -->
            </form>
            <p v-if="successMessage" class="text-success mt-2 text-center">{{ successMessage }}</p> <!-- Mensaje de error -->
        </div>
        </transition>
    </div>
</template>

<script>
// Tu script queda igual
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
                userTypeId: "",
            },
            errorMessage: "",
            successMessage: ""
        };
    },
    methods: {
        async enviarLogin() {
            this.errorMessage = '';
            try {
                //Hacemos la petición del tipo post a la ruta api/login y enviamos los datos email y password
                const response = await axios.post('/api/login', {
                    email: this.login.email,
                    password: this.login.password,
                });
                console.log('Aquí la response');
                console.log(response.data.token);
                const token = response.data.token;
                //Guardamos nuestro token en el localStorage
                //LocalStorage es una pequeña bd  a la que podamos acceder en cualquier momento desde el navegador
                localStorage.setItem('token', token);
                //Guardamos el id del tipo de usuario rol , en el localStorage, para mostrar el componente de voluntario o el de Org
                const userTypeId = response.data.user.userTypeId;
                localStorage.setItem('userTypeId', userTypeId);

                //Si los datos son correctos redirigimos a la ruta home, de lo contrario nos quedamos en la misma pagina
                this.$router.push({ name: 'home' });

                //El catch se ejecutará si los datos del user son incorrectos
            } catch (error) {
                console.log(error.response.data.message);
                //Enseñamos el mensaje de error si las credenciales son incorrectas
                this.errorMessage = error.response.data.message;

            }

        },

        async enviarRegistro() {
            this.errorMessage = '';
            try {
                //guardamos la respuesta de la petición del tipo POST a la ruta /api/register
                //la petición la recibe el AuthController
                const response = await axios.post('/api/register', {
                    name: this.registro.name,
                    email: this.registro.email,
                    password: this.registro.password,
                    password_confirmation: this.registro.password_confirmation,
                    userTypeId: this.registro.userTypeId
                    //rol: 'user' | 'org'
                });
                //si el registro es correcto, guardaremos el mensaje en el successMessage
                //si hay successMessage se mostrará el mensaje
                this.successMessage = response.data.message;

                //limpiamos los datos del form si todo es correcto
                this.registro = {
                    name: "",
                    email: "",
                    password: "",
                    password_confirmation: "",
                    userTypeId: "",
                };

                //Esperamos 3s
                await new Promise(resolve => setTimeout(resolve, 3000));
                //Mostramos el form Login
                this.formulario = "login"

                console.log(response.data);

                //Entramos al catch si falla la validación de los datos
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
.welcome-bg {
    background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
    min-height: 100vh;
    padding-top: 40px;
    padding-bottom: 40px;
}
.welcome-title {
    font-weight: 700;
    color: #3b82f6;
    letter-spacing: 1px;
    margin-bottom: 2rem;
}
.welcome-card {
    max-width: 430px;
    margin: 0 auto;
    border-radius: 18px;
    border: none;
    background: #fff;
    transition: box-shadow 0.2s;
}
.welcome-card:hover {
    box-shadow: 0 8px 32px 0 rgba(60, 72, 88, 0.18);
}
.welcome-btn {
    min-width: 140px;
    font-weight: 600;
    border-radius: 20px;
    transition: background 0.2s, color 0.2s;
}
.welcome-btn.active, .welcome-btn:focus {
    background: #3b82f6 !important;
    color: #fff !important;
    border-color: #3b82f6 !important;
}
.form-label {
    font-weight: 500;
    color: #374151;
}
input.form-control {
    border-radius: 12px;
    border: 1px solid #cbd5e1;
    font-size: 1rem;
    padding: 0.7rem 1rem;
    background: #f1f5f9;
    transition: border-color 0.2s;
}
input.form-control:focus {
    border-color: #3b82f6;
    background: #fff;
    box-shadow: 0 0 0 2px #3b82f633;
}
.btn-success, .btn-primary {
    border-radius: 20px;
    font-weight: 600;
    font-size: 1.1rem;
    padding: 0.6rem 0;
}
.text-primary {
    color: #3b82f6 !important;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.4s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
</style>
