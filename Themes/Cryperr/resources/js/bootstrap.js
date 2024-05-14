window._ = require('lodash');
window.axios = require('axios');

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.head.querySelector('meta[name="csrf-token"]');
const pusher_key = document.head.querySelector('meta[name="pusher-key"]');
const cluster = document.head.querySelector('meta[name="cluster"]');
const app_url = document.head.querySelector('meta[name="app-url"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.Pusher = new Pusher(pusher_key.content, {
    cluster: cluster.content,
    authEndpoint: app_url.content + "/pusher/auth", // Route xác thực Pusher
    auth: {
        headers: {
            "X-CSRF-TOKEN": token.content, // CSRF token
        },
    },
});

