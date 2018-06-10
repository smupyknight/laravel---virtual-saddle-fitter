const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// Make jQuery available inside webpack
mix.autoload({
    jquery: ['$', 'window.jQuery', "jQuery", "window.$", "jquery", "window.jquery"]
});

// Make jQuery available outside webpack, globally.
mix.webpackConfig({
    module: {
        rules: [
            {
                test: require.resolve('jquery'),
                use: [
                    {
                        loader: 'expose-loader',
                        options: '$'
                    },
                    {
                        loader: 'expose-loader',
                        options: 'jQuery'
                    },
                    {
                        loader: 'expose-loader',
                        options: 'jquery'
                    }
                ]
            }
        ]
    }
});

mix
    .js('resources/assets/js/admin/clients/clients.js', 'public/js/admin/clients')
    .js('resources/assets/js/admin/horses/horses.js', 'public/js/admin/horses')
    .js('resources/assets/js/admin/riders/riders.js', 'public/js/admin/riders')
    .js('resources/assets/js/admin/saddles/saddles.js', 'public/js/admin/saddles')
    .js('resources/assets/js/admin/bookings/bookings.js', 'public/js/admin/bookings')
    .js('resources/assets/js/admin/fitchecks/fitchecks.js', 'public/js/admin/fitchecks')

    .js('resources/assets/js/client/horses/horses.js', 'public/js/client/horses')
    .js('resources/assets/js/client/my-fitters/my-fitters.js', 'public/js/client/my-fitters')
    .js('resources/assets/js/client/bookings/bookings.js', 'public/js/client/bookings')
    .js('resources/assets/js/client/riders/riders.js', 'public/js/client/riders')

    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .extract([
        'axios',
        'bootstrap-sass',
        'sweetalert',
        'jquery',
        'lodash',
        'moment',
        'vue',
        'vue-router',
        'element-ui'
    ]);