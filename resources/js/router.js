import { createRouter, createWebHistory } from 'vue-router';
import Welcome from './components/Welcome.vue';
import Home from './components/Home.vue';
import Event from './components/Events/Event.vue';
import MyEvents from './components/Events/MyEvents.vue';
import CreateEvent from './components/Events/createEvent.vue';
import EditEvent from './components/Events/EditEvent.vue';
import Participants from './components/Events/Participants.vue';
import ExploreEvents from './components/Events/ExploreEvents.vue';

const routes = [
  { path: '/', component: Welcome, name: 'welcome' },
  { path: '/home', component: Home, name: 'home' },
  { path: '/explore-events', component: ExploreEvents, name: '/explore-events' },
  { path: '/event/:id', component: Event, name: 'event-detail' },
  { path: '/my-events', component: MyEvents, name: 'my-events' },
  { path: '/create-event', component: CreateEvent, name: 'create-event' },
  { path: '/edit-event/:id', component: EditEvent, name: 'edit-event' },
  { path: '/event/:id/participants', component: Participants, name: 'participants' },
  
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;