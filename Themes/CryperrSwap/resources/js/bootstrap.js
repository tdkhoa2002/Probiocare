window._ = require('lodash');
window.axios = require('axios');

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.Pusher = new Pusher('d2f1a2d242ef8c8315dc', {
    cluster: 'ap1'
}); 
