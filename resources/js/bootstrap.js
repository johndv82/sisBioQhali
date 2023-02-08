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
import example from './components/example-component'
import table_producto from './components/producto/table-producto-component'
import table_categoria from './components/categoria/table-categoria-component'
import new_producto from './components/producto/new-producto-component'
import new_categoria from './components/categoria/new-categoria-component'
import react_ejemplo_componente from './components/categoria/react-ejemplo-component'

//Inicializar VUE3
const app = createApp({})

app.component('example-component', example)
app.component('table-producto-component', table_producto)
app.component('table-categoria-component', table_categoria)
app.component('new-producto-component', new_producto)
app.component('new-categoria-component', new_categoria)
app.component('react-ejemplo-component', react_ejemplo_componente)
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
