import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import OrderTracker from './components/OrderTracker.vue';
app.component('order-tracker', OrderTracker);

app.mount('#app');