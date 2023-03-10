window._ = require('lodash');
import Popper from 'popper.js/dist/umd/popper';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = Popper;
    require('bootstrap');
} catch (e) {
}

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Configuration VUE3 + Components
import { createApp } from 'vue'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import categoriaComponent from "./components/categoria/categoria-component";
import productoComponent from './components/producto/producto-component';
import membresiaComponent from './components/membresia/membresia-component';

//Inicializar VUE3
const app = createApp({})

app.use(VueSweetalert2);
app.component('categoria-component', categoriaComponent)
app.component('producto-component', productoComponent)
app.component('membresia-component', membresiaComponent)
app.mount('#app')




/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
