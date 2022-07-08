window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

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
//     forceTLS: true
// });
import Echo from 'laravel-echo'
window.io = require('socket.io-client');
window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: `${window.location.protocol}//${window.location.hostname}:6001`
    })
    // var connectionOptions = {
    //     "force new connection": true,
    //     "reconnectionAttempts": "Infinity", //avoid having user reconnect manually in order to prevent dead clients after a server restart
    //     "timeout": 10000, //before connect_error and connect_timeout are emitted.
    //     "transports": ["websocket"]
    // };

// window.socketio = socket(`${window.location.protocol}//${window.location.hostname}:3000`, connectionOptions);
// window.socketio.on("error", (error) => {
//     console.log("socket error");
// });
// window.socketio.on("connect", () => {
//     console.log(socket); // true
// });
// window.socketio.on("data", () => {
//     console.log("socket data");
// });
// window.socketio.io.on("reconnect", () => {
//     console.log("reconnect socket data");
// });