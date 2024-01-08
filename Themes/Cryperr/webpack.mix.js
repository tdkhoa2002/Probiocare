let mix = require('laravel-mix');
mix.disableNotifications()
const themeInfo = require('./theme.json');
if (mix.inProduction()) {
    mix.version();
    const pathAssetCompile = "./assets/";
    mix.setPublicPath(pathAssetCompile);
    mix.sass('resources/sass/main.scss', '/css/main.css');
    mix.js('resources/js/app.js', '/app').vue({ version: 2 });
    mix.scripts(['resources/js/jquery-pincode-autotab.js'], pathAssetCompile + '/js/lib.js');
    mix.scripts(['resources/js/script.js'], pathAssetCompile + '/js/script.js');
    mix.copy('resources/fonts', pathAssetCompile + '/fonts');
    mix.copy('resources/images', pathAssetCompile + '/images');
} else {
    const pathPublicTheme = 'public/themes/' + themeInfo.name.toLowerCase();
    mix.sourceMaps();
    mix.setPublicPath('../../').sass('resources/sass/main.scss', pathPublicTheme + '/css/main.css')
    mix.js('resources/js/app.js', pathPublicTheme + '/app').vue({ version: 2 });
    mix.scripts(['resources/js/jquery-pincode-autotab.js'], "../../" + pathPublicTheme + '/js/lib.js');
    mix.scripts(['resources/js/script.js'], "../../" + pathPublicTheme + '/js/script.js');
    mix.copy('resources/fonts', "../../" + pathPublicTheme + '/fonts');
    mix.copy('resources/images', "../../" + pathPublicTheme + '/images');
}
