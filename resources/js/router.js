import { createRouter, createWebHistory } from 'vue-router';
import App from './components/App.vue';
import Home from './components/Home.vue';

const routes = [
  { path: '/', component: Home, name: 'home' },
  { path: '/login', component: App, name: 'login' },
  { path: '/register', component: App, name: 'register' },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;