import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from './Pages/DashboardBase.vue';
import ChatCreate from './Pages/CreateChat.vue';
import Messages from './Pages/Messages.vue';

const routes = [
    {
        path: '/dashboard',
        component: Dashboard,
    },
    {
        path: '/chats/create',
        component: ChatCreate,
    },
    {
        path: '/chats/:id',
        component: Messages,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
