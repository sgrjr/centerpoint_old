<<<<<<< HEAD
window._ = require('lodash');

window.axios = require('axios');
=======
window._ = require('../../node_modules/lodash/fp/all.js');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('../../node_modules/axios/dist/axios.js');
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

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
//     encrypted: true
<<<<<<< HEAD
// });
=======
// });
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
