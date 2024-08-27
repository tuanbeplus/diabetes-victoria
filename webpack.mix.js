const mix = require('laravel-mix');
mix
    .js('./assets/js/main.js', './assets/js/main.bundle.js') 
    .js('./assets/js/member-login.js', './assets/js/member-login.bundle.js') 
    .sass('./assets/scss/main.scss', './assets/css/main.bundle.css') 
    