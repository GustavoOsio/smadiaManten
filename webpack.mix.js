let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
    .copyDirectory('resources/assets/image/', 'public/img/')
    //.copy('node_modules/animate.css/animate.css', 'resources/assets/sass/_animate.scss')
    //.copy('node_modules/fullcalendar/dist/fullcalendar.css', 'resources/assets/sass/_fullcalendar.scss')
    //.copy('node_modules/select2/dist/select2.min.css', 'resources/assets/sass/_select2.scss')
    //.copy('node_modules/webcamjs/webcam.min.js', 'public/js/webcam.min.js')
    //.copy('node_modules/webcamjs/webcam.swf', 'public/js/')
    //.copy('node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js', 'public/js/')
    //.copy('node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css', 'public/css/')
   .sass('resources/assets/sass/app.sass', 'public/css')
    .mix.version();
