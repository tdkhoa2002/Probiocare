let mix = require('laravel-mix');
mix.disableNotifications()
const themeInfo = require('./theme.json');
const pathPublicTheme = 'public/themes/' + themeInfo.name.toLowerCase();
/**
 * Compile sass
 */
mix.setPublicPath('../../');
mix.sass('resources/sass/main.scss', pathPublicTheme + '/css/main.css')

/**
 * Concat scripts
 */
mix.scripts(['resources/js/script.js'], pathPublicTheme + '/js/all.js');

mix.js('resources/js/app.js', pathPublicTheme + '/app').vue({ version: 2 });

mix.copy('resources/fonts', pathPublicTheme + '/fonts');
mix.copy('resources/images', pathPublicTheme + '/images');