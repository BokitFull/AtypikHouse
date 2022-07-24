const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
// directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

/*
 * ENTRY CONFIG
 *
 * Each entry will result in one JavaScript file (e.g. app.js)
 * 
 * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
 */
.addEntry('app', './assets/app.js')
    // .addEntry('login', './assets/js/login.js')
    .addEntry('navbar', './assets/js/navbar.js')
    .addEntry('calendar', './assets/js/calendar.js')
    .addEntry('checkout', './assets/js/checkout.js')
    .addEntry('homeJs', './assets/js/index.js')
    .addEntry('add_collection_widget', './assets/js/add-collection-widget.js')

    .addStyleEntry('app_s', './assets/styles/app.scss')
    .addStyleEntry('navbar_s', './assets/styles/navbar.scss')
    .addStyleEntry('calendar_s', './assets/styles/calendar.scss')
    .addStyleEntry('all_habitats', './assets/styles/habitats/all_habitats.scss')
    .addStyleEntry('footer', './assets/styles/footer.scss')
    .addStyleEntry('home', './assets/styles/home.scss')
    .addStyleEntry('user_home', './assets/styles/users/user_home.scss')
    .addStyleEntry('user_edit', './assets/styles/users/user_edit.scss')
    .addStyleEntry('user_reservations', './assets/styles/users/user_reservations.scss')
    .addStyleEntry('user_reservations_detail', './assets/styles/users/user_reservations_detail.scss')
    .addStyleEntry('hote_habitats', './assets/styles/hotes/habitats.scss')
    .addStyleEntry('habitat_show', './assets/styles/habitats/habitats_detail.scss')
    .addStyleEntry('habitat_edit', './assets/styles/habitats/habitats_edit.scss')
    .addStyleEntry('habitat_delete', './assets/styles/habitats/habitats_delete.scss')
    .addStyleEntry('payment_index', './assets/styles/payment.scss')

// enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
.enableStimulusBridge('./assets/controllers.json')

// When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
.splitEntryChunks()

// will require an extra script tag for runtime.js
// but, you probably want this, unless you're building a single-page app
.enableSingleRuntimeChunk()

/*
 * FEATURE CONFIG
 *
 * Enable & configure other features below. For a full
 * list of features, see:
 * https://symfony.com/doc/current/frontend.html#adding-more-features
 */
.cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

.configureBabel((config) => {
    config.plugins.push('@babel/plugin-proposal-class-properties');
})

// enables @babel/preset-env polyfills
.configureBabelPresetEnv((config) => {
    config.useBuiltIns = 'usage';
    config.corejs = 3;
})

// enables Sass/SCSS support
.enableSassLoader()

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you use React
//.enableReactPreset()

// uncomment to get integrity="..." attributes on your script & link tags
// requires WebpackEncoreBundle 1.4 or higher
//.enableIntegrityHashes(Encore.isProduction())

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();