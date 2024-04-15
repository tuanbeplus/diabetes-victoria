const mix = require('laravel-mix');
mix
    .js('./assets/js/main.js', './assets/js/main.bundle.js') // If need to mix JS
    .sass('./assets/scss/main.scss', './assets/css/main.css') // If need to mix SCSS