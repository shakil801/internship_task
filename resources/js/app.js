import './bootstrap';
import {createApp} from 'vue';
import router from './router';

import App from './APP.vue';

createApp(App)
.use(router)
.mount('#app')