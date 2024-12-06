const mix = require("laravel-mix");
require("laravel-mix-purgecss");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js").js("resources/js/quote-request.js", "public/js").version();

mix
    .sass("resources/scss/theme.scss", "public/css")
    .postCss("public/css/theme.css", "public/css/theme.css", [
        require("autoprefixer")
    ])
    .version();
